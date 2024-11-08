<? 
namespace App\Events;

//use Illuminate\Console\Command;

class SendChatMessage extends Controller //Command
{
    /**
     * Create a new event instance.
     *
     * @param PHPSocketIO\SocketIO $server
     * @return void
     */
    public function __construct($server)
    {
		$server->on('connection', function($socket) use($server) {
			$socket->on('chat message', function($message) use($server) {
				$server->emit('chat message', $message);
			});
		});
    }
}