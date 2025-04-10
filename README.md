# nginx back
```
server {
    listen 8879 ssl;
    server_name testbilimzet.kz www.testbilimzet.kz;
    
   
    root /var/www/bilimzet/public;
    ssl_certificate /etc/letsencrypt/new/new_certificate.pem; # managed by Certbot
    ssl_certificate_key /etc/letsencrypt/new/new_certificate.key; # managed by Certbot

    client_max_body_size 100M;    
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.html index.htm index.php; 

    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_prefer_server_ciphers on;
  

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location /storage/ {
       add_header 'Access-Control-Allow-Origin' '*';
       add_header 'Access-Control-Allow-Methods' 'GET, OPTIONS';
       add_header 'Access-Control-Allow-Headers' 'Content-Type, Authorization';
    }

}
```
# nginx front
```
server{
        listen 80;
        server_name testbilimzet.kz www.testbilimzet.kz;
        return 301 https://$host$request_uri;
}
server {
    listen 443 ssl;
    server_name testbilimzet.kz www.testbilimzet.kz;
    

    location /api/ {
      proxy_pass http://127.0.0.1:8879/api/; # Прокси запросов к бэкенду
      proxy_set_header Host $host;
      proxy_set_header X-Real-IP $remote_addr;
      proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
      proxy_set_header X-Forwarded-Proto $scheme;
    }
    root /var/www/bilimzet-front/dist;
    index index.html;

    ssl_certificate /etc/letsencrypt/new/new_certificate.pem; # managed by Certbot
    ssl_certificate_key /etc/letsencrypt/new/new_certificate.key; # managed by Certbot
    
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_prefer_server_ciphers on;
   

    location / {
        try_files $uri /index.html;
    }

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    location ~ /\. {
        deny all;
    }
}
```
