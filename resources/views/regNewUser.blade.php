@extends('layouts.base')

@section('content')

<style>
form {
	background-color:#ffffff;
}
.material-zhar-block{
    display: block;
    background: #fff;
    padding:20px;
}
.matzharblocktitle{
    display: block;
    font-family: 'gilbd';
    font-size: 30px;
    color: #000000;
    margin:0px 0px 20px;
}
.matzharinformationtextblock{
    display: block;
    background: #E6F7E8;
    border-radius: 4px;
    padding: 15px 20px;
    margin-bottom: 10px;
}

.kualik-content{
    display: block;
    position: relative;
    max-height: 600px;
    overflow: auto;
    padding: 10px;
}
.kualikjpeg{
    display: block;
    width: 100%;
}
.kualik-content .closeversions{
    position: fixed;
    right: 18px;
}
.matinfosvg{
    display: block;
    float: left;
}
.matinfotextbl{
    display: block;
    width: calc(100% - 30px);
    float: left;
    padding-left: 15px;
}
.matinfotext1{
    display: block;
    margin: 0px;
    font-family: 'gilsb';
    font-size: 16px;
    color: #03B113;
}
.matinfotext1span{
    display: block;
    font-family: 'gilreg';
}
.matzharvideoblock{
    display: block;
    width: 100%;
    background: #EFF3FF;
    border-radius: 4px; 
    padding:15px 20px;
}
.matinfosvgplaytext {
    display: block;
    float: left;
    font-family: 'gilsb';
    font-size: 18px;
    color: #1C77FD;
    margin: 5px 15px;
}
.matarrzhbt {
    display: block;
    float: right;
    margin-top: 6px;
    transition: 0.3s all;
}
.matzharvidblockp1{
    display: block;
    cursor: pointer;
}
.matzharvidblockp2{
    display: none;
    padding-top: 20px;
}
.videonuskmatzhr{
    display: block;
    border-radius: 6px;
    height: 400px;
}
.form-blocks-zharialau{
    display: block;
    width: 100%;
    margin-top: 30px;
}
.matzharlabelsel{
    display: block;
    font-family: 'gilsb';
    font-size: 18px;
    color: #000000;
    margin: 0px 10px 10px 0px;
    float: left;
}
.matlabelsinform{
    display: block;
    float: left;
    background: #EFF3FF;
    width: 20px;
    height: 20px;
    text-align: center;
    border-radius: 20px;
    font-family: 'gilbd';
    font-size: 12px;
    color: #1C77FD;
    padding-top: 2px;
    position: relative;
    cursor: pointer;
}
.matlabelsinform:hover .matlabinftext{
    display: block;
}
.matzhatnewinput{
    display: block;
    width: 100%;
    height: 45px;
    background: #F8F8F8;
    border: 0.5px solid #909090;
    border-radius: 4px;
    font-family: 'gilreg';
    font-size: 14px;
    padding:0px 15px;
    outline: none;
}
.marbt30{
    margin-bottom: 30px;
	padding: 0 5px;
}
.matzhatnewtextarea{
    display: block;
    max-width: 100%;
    min-width: 100%;
    width: 100%;
    min-height: 90px;
    background: #F8F8F8;
    border: 0.5px solid #909090;
    border-radius: 4px;
    padding: 15px;
    outline: none;
}
.form-blocks-zharialau-flex{
    display: flex;
    flex-wrap: wrap;
    flex-direction: row;
    justify-content: space-between;
    align-items: stretch;
    margin-bottom: 20px;
}
.form-block-parts{
    display: block;
    width: 32%;
}
.matzharlists{
    display: block;
    width: 100%;
    background-color: #EFF3FF;
    border: 0.5px solid #909090;
    box-sizing: border-box;
    border-radius: 4px;
    height: 45px;
    font-family: 'gilreg';
    font-size: 14px;
    color: #1C77FD;
    padding: 0px 15px;
    background: url(/img/komek/arrb.svg)no-repeat;
    background-position: 96% 12px;
    -moz-appearance: none;
	-webkit-appearance: none;
    cursor: pointer;
    outline: none;
}
.matzharzhetbtns{
    display: inline-block;
    width: 100px;
    height: 40px;
    background: #EFF3FF;
    border-radius: 6px;
    font-family: 'gilsb';
    font-size: 14px;
    color: #1C77FD;
    border: none;
    transition: 0.3s all;
    text-align: center;
    padding-top: 9px;
    cursor: pointer;
}
.matzharzhetbtns:hover{
    color:#fff;
    background: #254EE2;
}
.fileinputform{
    display: block;
    position: relative;
    background: #EFF3FF;
    border: 1px dashed #1C77FD;
    border-radius: 6px;
    height: 310px;
    cursor: pointer;
    transition: 0.3s all;
}
.fileinputform .help-block {
    margin-top: 30px;
    text-align: center;
}
.fileinputmatzhar{
    display: block;
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    opacity: 0;
    cursor: pointer;
}
.matfileextensions{
    display: block;
    font-family: 'gilsb';
    font-size: 14px;
    text-align: center;
    color: #000000;
}
.matfileextensions span{
    display: block;
    font-family: 'gilreg';
}
#upload_matzhar{
    display: block;
    height: 220px;
    margin:0 auto;
}
.filedownload_h4{
    display: block;
    text-align: center;
    text-decoration: underline;
    color:#1C77FD;
    font-family: 'gilsb';
    font-size:14px;
}
.matzhar_by_btnn{
    display: block;
    width: 260px;
    height: 50px;
    background: #1C77FD;
    border-radius: 6px;
    border:none;
    font-family: 'gilsb';
    font-size: 16px;
    color: #FFFFFF;
    margin:0 auto;
    transition: 0.3s all;
}
.matzhar_by_btnn:hover{
    background: #254EE2;
}
.btnmatzhartext{
    display: block;
    font-family: 'gilreg';
    font-size: 16px;
    text-align: center;
    color: #000000;
}
.matzharrulesfor{
    color:#1C77FD;
    cursor: pointer;
}
.modalerezhe{
    display: block;
    padding: 25px;
    max-height: 400px;
    overflow: auto;
}
.matzharloader{
    display: none;
    padding-top: 100px;
}
.matzharproc{
    display: block;
    font-family: 'gilsb';
    font-size: 18px;
    text-align: center;
    color: #000000;
}
.lineload{
    display: block;
    height: 10px;
    width: 60%;
    background: none;
    border-radius: 50px;
    margin:0 auto;
    position: relative;
}
.lineload2{
    display: block;
    height: 10px;
    background: #BBD7FF;
    border-radius: 50px;
}
.matnameforsc{
    display: block;
    font-family: 'gilreg';
    font-size: 14px;
    text-align: center;
    color: #1C77FD;
    margin-top: 25px;
}
.fileinputform-active{
    background: #E6F7E8;
    border: 1px dashed #03B113;
    transition: 0.3s all;
}
.donematzhcl{
    display: none;
}
.donematzhtext{
    display: block;
    text-align: center;
    font-family: 'gilsb';
    font-size: 14px;
    text-align: center;
    color: #03B113;
}
.matfilenamelike{
    display: block;
    font-family: 'gilreg';
    font-size: 14px;
    color: #000000;
    float: left;
    margin: 0;
}
.fileozgerttype{
    display: block;
    float: left;
    font-family: 'gilsb';
    font-size: 14px;
    text-decoration-line: underline;
    color: #1C77FD;
    margin:0px 0px 0px 10px;
}
.ozgpenmatzh{
    margin-right: 5px;
}
.filesdonematzhd{
    display: block;
    width: fit-content;
    margin: 0 auto;
}
#done_matzhar{
    display: block;
    margin: 0 auto;
    width: 167px;
    margin-top: 35px;
}
.mindettiemestext{
    display: block;
    float: right;
    font-family: 'gilreg';
    font-size: 12px;
    color: #03B113;
    margin: 0;
}
.matzharzhetbtns-active{
    background: #254EE2;
    color:#fff;
}
.zhetekshimatzharbt{
    display: none;
}
.material_marapat{
    display: block;
    background: #fff;
    padding:25px;
}
.marapattartitleel{
    display: block;
    font-family: 'gilbd';
    font-size: 30px;
    color: #000000;
    margin-top:0px;
}
.undertitletext{
    display: block;
    font-family: 'gilreg';
    font-size: 16px;
    color: #000000;
    margin-bottom: 25px;
}
.undertitleline{
    display: block;
    background: #CBCBCB;
    width: 100%;
    height: 1px;
}
.marapattar_chbblo{
    display: block;
    width: 100%;
}
.marptchblp1{
    display: block;
    float: left;
    width: 80px;
}
.marptchblp2{
    display: block;
    width: calc(100% - 80px);
    float: left;
    padding: 20px 0px;
}
.marpchbgal {
    display: block;
    width: 20px;
    height: 20px;
    border: 2px solid #1C77FD;
    border-radius: 4px;
    margin: 35px auto 0px;
    cursor: pointer;
    text-align: center;
    transition: 0.3s all;
}
.marpchbgal-active{
    background: #1C77FD;
}
.marptchtt{
    display: block;
    font-family: 'gilsb';
    font-size: 20px;
    color: #000000;
    margin: 0px 0px 5px;
}
.priceofvers{
    display: block;
    font-family: 'gileb';
    font-size: 20px;
    color: #03B113;
    margin: 0px;
}
.versionsofpriz{
    display: block;
    font-family: 'gilreg';
    font-size: 18px;
    text-decoration: underline;
    color: #808080;
    margin: 0px;
    cursor: pointer;
}
.marptchblp21{
    display: block;
    float: left;
    width: fit-content;
}
.marptchblp22{
    display: block;
    float: right;
    width: fit-content;
    padding-top: 15px;
}
.mt-9{
    margin-top: -9px;
}
.bought_btnblock{
    display: block;
    width: 260px;
    float: right;
    padding-top: 40px;
}
.summatitle{
    display: block;
    font-family: 'gilreg';
    font-size: 16px;
    color: #000000;
    float: left;
    margin-top: 0px;
}
.summaofprizesmat{
    display: block;
    font-family: 'gilsb';
    font-size: 16px;
    color: #000000;
    float: right;
    margin-top: 0px;
}
.getmarpbtno{
    display: block;
    width: 100%;
    height: 50px;
    background: #1C77FD;
    border-radius: 6px;
    border: none;
    font-family: 'gilsb';
    font-size: 16px;
    color: #FFFFFF;
    transition: 0.3s all;
}
.getmarpbtno:hover{
    background: #254EE2;
}
.nuskalar-block{
    display: block;
    background: #fff;
    padding: 20px 50px;
    position: relative;
}
.closexsvg{
    display: block;
    width: 20px;
    height: 20px;
    border-radius: 50px;
    border:none;
    background: #C4C4C4;
    position: absolute;
    top: 5px;
    right: 5px;
    transition: 0.3s all;
}
.closexsvg img{
    display: block;
    height: 16px;
    margin-left: -4px;
}
.download_doc_btn{
    display: block;
    width: 265px;
    height: 60px;
    background: #1C77FD;
    border-radius: 6px;
    font-family: 'gilsb';
    font-size: 18px;
    color: #FFFFFF;
    transition: 0.3s all;
    border:none;
    transition: 0.3s all;
}
.material-content-body-block-head-logo{
    display: block;
    float: left;
}
.matheadlgtt1{
    display: block;
    font-family: 'gilreg';
    font-size: 14px;
    color: #FFFFFF;
    margin: 0px;
    margin-left: 15px;
    float: left;
}
.matheadlgtt2{
    display: block;
    font-family: 'gilreg';
    font-size: 14px;
    color: #FFFFFF;
    margin: 0px;
    float: right;
}
.material-download-certificate{
    display: block;
    width: 1110px;
    padding: 40px 80px;
    position: relative;
    overflow: hidden;
    background: #FFFFFF;
    box-shadow: 0px 4px 50px rgba(0, 0, 0, 0.25);
    border-radius: 6px;
    margin: 0 auto 60px;
}
.certificatenuska{
    display: block;
    width: 420px;
    margin: 0 auto;
    background: #F1F1F1;
    padding: 20px 40px;
}
.nusk_certdown{
    display: block;
    width: 100%;
}
.certsokvcjs_downa{
    display: block;
    width: 225px;
    height: 40px;
    background: #1C77FD;
    border-radius: 6px;
    border:none;
    outline: none;
    font-family: 'gilreg';
    font-weight: 600;
    font-size: 14px;
    color: #FFFFFF;
    margin: 20px auto;
    transition: 0.3s all;
}
.certsokvcjs_downa:hover{
    background: #254EE2;
}
.materloadertt1_cert{
    display: block;
    font-family: 'gilreg';
    font-size: 18px;
    text-align: center;
    color: #000000;
    margin: 0px;
}
.download_doc_btn:hover{
    background: #254EE2;
}
#mater-done{
    display: none;
}
.materloadertt4{
    display: block;
    font-family: 'gilreg';
    font-size: 16px;
    color: #808080;
}
.materloadertt5{
    display: block;
    font-family: 'gilreg';
    font-size: 14px;
    color: #000000;
}
.closexsvg:hover{
    background: #FF0000;
}
.shiwnusktitle{
    display: block;
    font-family: 'gilbd';
    font-size: 30px;
    color: #000000;
}
.shiwnusktitleunder{
    display: block;
    font-family: 'gilreg';
    font-size: 16px;
    color: #808080;
}
.nuskaimagesflex{
    display: flex;
    flex-wrap: wrap;
    flex-direction: row;
    justify-content: space-between;
    align-items: stretch;
    width: 100%;
    margin-top: 45px;
}
.nuskimageblock{
    display: block;
    width: 32%;
    position: relative;
}
.nuskaimage{
    display: block;
    width: 80%;
    position: relative;
    margin: 0 auto;
    border-radius: 6px;
    overflow: hidden;
    cursor: pointer;
}
.ulgilersvg{
    display: block;
    width: 100%;
    margin: 0 auto;
    max-width: 100%;
}
.checknuskabutton{
    display: block;
    width: 80%;
    max-width: 100%;
    background: #1C77FD;
    border-radius: 6px;
    height: 40px;
    font-family: 'gilsb';
    font-size: 14px;
    color: #FFFFFF;
    margin: 0 auto;
    border:none;
    margin-top:25px;
    transition: 0.3s all;
}
.checknuskabutton:hover{
    background: #254EE2;
}
.checkednuska{
    display: none;
    position: absolute;
    background: #0000006b;
    height: 100%;
    width: 100%;
    cursor: pointer;
    z-index: 10;
}
.galochka_nuska{
    display: block;
    width: 20px;
    height: 20px;
    background: #1C77FD;
    text-align: center;
    border-radius: 4px;
    margin: 10px 0px 0px 10px;
}
.galochka_nuska img{
    margin-top: -3px;
}
.checknuskabutton-active{
    background: #CBCBCB;
}
.checknuskabutton-active:hover{
    background: #CBCBCB!important;
}
.tnd2t{
    display: none;
}
.checknuskabutton-active .tnd1t{
    display: none;
}
.checknuskabutton-active .tnd2t{
    display: block;
}
.payforttunderdiv{
    display: flex;
    flex-wrap: wrap;
    flex-direction: row;
    justify-content: space-between;
    align-items: stretch;
}
.payforttunderdivp{
    display: block;
    width: 22%;
    background: #03B113;
    border-radius: 10px;
    padding: 10px 5px;
    font-family: 'gilreg';
    font-size: 12px;
    color: #FFFFFF;
    text-align: center;
    transition: 0.3s all;
}
.payforttunderdivp-active{
    background: #E6F7E8;
    border-radius: 10px;
    color: #03B113;
}
.payforttunderdivp-active .donesvg{
    display: initial;
}
.payforttunderdivp-active span{
    display: none;
}
.donesvg{
    display: none;
    margin-right: 5px;
}
.striplines {
    display: block;
    width: 17%;
    border-top: 2px dashed #CBCBCB;
    margin-top: 16px;
    height: 2px;
}
.striplinesact{
    border-top:2px dashed #03B113;
}
.payformnumber{
    font-family: 'gileb';
    font-size: 12px;
    color: #FFFFFF;
    margin-right: 5px;
}
.payforttunderdivp-next{
    background: #CBCBCB;
}
.tolemblocktext1{
    display: block;
    font-family: 'gilreg';
    font-size: 16px;
    color: #000000;
    margin:0px 0px 30px;
}
.tolemblocktext2{
    display: block;
    font-family: 'gilreg';
    font-size: 24px;
    color: #808080;
    margin:0px 0px 15px;
}
.tolemblocktext2bolder{
    font-family: 'gilbd';
    color:#03B113;
}
.payformat-tolemblock{
    display: block;
    margin-top:40px;
    padding-bottom: 50px;
}
.formatpaybuttons{
    display: block;
    background: #1C77FD;
    border-radius: 6px;
    width: 200px;
    height: 40px;
    font-family: 'gilsb';
    font-size: 14px;
    color: #FFFFFF;
    border:none;
    border-radius: 6px;
    transition: 0.3s all;
}
.formatpaybuttons-dis{
    display: block;
    background: #CBCBCB;
    border-radius: 6px;
    width: 200px;
    height: 40px;
    font-family: 'gilsb';
    font-size: 14px;
    color: #FFFFFF;
    border:none;
    border-radius: 6px;
    transition: 0.3s all;
}
.tolemblocktext3{
    display: block;
    font-family: 'gilreg';
    font-size: 14px;
    color: #808080;
    margin:10px 0px 30px;

}
.formatpaybuttons:hover{
    background: #254EE2;
}
.bottom-block-pay{
    display: block;
    border-top:1px solid #F1F1F1;
    padding: 15px 50px;
}
.bottom-block-paytxt{
    display:block;
    font-family: 'gilreg';
    font-size: 16px;
    color: #808080;
    margin:0px;
}
.payformat-tolemblock-done{
    display: none;
}
#paydone{
    display: block;
    width: 170px;
    margin: 30px auto;
}

.matlabinftext {
    display: none;
    width: 300px;
    padding: 5px 10px;
    background: #fff;
    position: relative;
    border: 1px solid #11111163;
    top: -24px;
    left: 30px;
    border-radius: 6px;
    text-align: left;
    z-index: 1000;
}

.materialsmineblockhead {
    display: block;
    background: #F4F4F4;
    border-radius: 6px 6px 0px 0px;
    padding: 10px 20px;
}
.matheadsvgs{
    display: block;
    float: left;
}
.matmnbcal{
    display: block;
    font-family: 'gilreg';
    font-size: 14px;
    color: #707070;
    float: left;
    margin: 0px 25px 0px 10px;
}
.matheaderactionsbtn{
    display: block;
    float: left;
    background: none;
    border:none;
    font-family: 'gilsb';
    font-size: 14px;
    color: #1C77FD;
    margin-right: 20px;
}
.matheaderactionsbtn2{
    display: block;
    float: left;
    background: none;
    border:none;
    font-family: 'gilsb';
    font-size: 14px;
    color: #FF0000;
}
.matheaderactions{
    display: block;
    width: fit-content;
    float: right;
}
.matmineactsvg {
    margin-top: -3px;
    margin-right: 5px;
}
.materialsmineblockcontent{
    display: block;
    padding: 10px 20px 20px;
}
.materialsmineblock{
    display: block;
    margin-bottom: 25px;
}
.marapatsminematsblock{
    display: flex;
    flex-wrap: wrap;
    flex-direction: row;
    justify-content: space-between;
    align-items: stretch;
    width: 100%;
    margin-top: 15px;
}
.marapatsminematsblockinn{
    display: block;
    width: 24%;
    background: #FFF7E7;
    border-radius: 4px;
    padding: 15px;
}
.marapatsminematsblockinntext1{
    display: block;
    margin: 0px 0px 10px;
    font-family: 'gilsb';
    font-size: 14px;
    color: #303030;
}
.matlabinftext{
    color:#000;
}
.galoc_mats{
    display: block;
    float: left;
}
.spannuska{
    font-size: 14px;
    color:#1C77FD;
    font-family: 'gilreg';
}
.galoctxt{
    display: block;
    font-family: 'gilsb';
    font-size: 14px;
    color: #03B113;
    float: left;
    margin: 0px 0px 10px 10px;
}
.galocdownloadtxt{
    display: block;
    cursor: pointer;
    font-family: 'gilsb';
    font-size: 14px;
    color: #1C77FD;
    margin: 0;
    transition: 0.3s all;
}
.galocdownloadtxt:hover{
    color:#254EE2;
    text-decoration: underline;
}
.marapatsminematsblockinn-success{
    background: #E6F7E8;
}
.matsminegalocprice{
    display: block;
    font-family: 'gilreg';
    font-size: 16px;
    color: #303030;
    margin:0px 0px 10px;
}
.tolepalubtnlinetxt{
    display: block;
    font-family: 'gilsb';
    font-size: 14px;
    color: #1C77FD;
    margin: 0;
    cursor: pointer;
}
.vaecsvg{
    margin-left:5px;
}
.versions-block{
    display: block;
    padding: 40px 70px;
    position: relative;
}
.titlevers{
    display: block;
    font-family: 'gilbd';
    font-weight: bold;
    font-size: 30px;
    color: #000000;
    margin: 0px 0px 15px;
}
.steptitlesvers{
    display: block;
    font-family: 'gilreg';
    font-size: 12px;
    color: #FFFFFF;
}
.steptitlesvers span{
    font-family: 'gileb';
    font-size: 12px;
    color: #FFFFFF;
    margin: 5px;
}
.stepsoversionblock{
    display: flex;
    flex-wrap: wrap;
    flex-direction: row;
    justify-content: space-between;
    align-items: stretch;
    margin-bottom: 40px;
    width: 100%;
}
.stepsoversionbl_inn{
    display: block;
    width: 18%;
    text-align: center;
    transition: 0.3s all;
}
.stepsoversionbl_inn-next{
    background: #CBCBCB;
    border-radius: 10px;
}
.stepsoversionbl_inn-active{
    background: #03B113;
    border-radius: 10px;
}
.closeversions {
    display: block;
    width: 20px;
    height: 20px;
    background: #C4C4C4;
    border-radius: 50px;
    border: none;
    padding: 0;
    position: absolute;
    top: 10px;
    right: 10px;
    transition: 0.3s all;
}
.closeversions:hover{
    background: red;
}
.closeversions img{
    margin-top: -2px;
}
.blocklinedashed {
    display: block;
    border-top: 2px dashed #CBCBCB;
    height: 2px;
    margin-top: 15px;
}
.vercerbltext{
    display: block;
    font-family: 'gilreg';
    font-size: 16px;
    color: #000000;
    margin: 0px 0px 10px;
}
.certs_versions_flex{
    display: flex;
    flex-wrap: wrap;
    flex-direction: row;
    justify-content: space-between;
    align-items: stretch;
    width: 100%;
}
.certversflitems{
    display: block;
    width: 31%;
    background: #FFF7E7;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.08);
    border-radius: 6px;
    padding: 15px;
}
.certversimg{
    display: block;
    max-width: 100%;
    width: 160px;
    margin: 0 auto;
}
.certtangdaubtnversion{
    display: block;
    width: 160px;
    max-width: 100%;
    margin:20px auto 0px;
    background: #1C77FD;
    border-radius: 6px;
    font-family: 'gilsb';
    font-size: 14px;
    color: #FFFFFF;
    border:none;
    height: 40px;
    transition: 0.3s all;
}
.certtangdaubtnversion:hover{
    background: #254EE2;
}
.blocklinedashed-active{
    border-top: 2px dashed #03B113;
}
.versiondonemats{
    display: none;
}
.stepsoversionbl_inn-success{
    background: #E6F7E8;
    border-radius: 10px;
}
.stepsoversionbl_inn-success .steptitlesvers{
    color: #03B113;
}
.stepsoversionbl_inn-success .versiondonemats{
    display: initial;
    margin-right: 5px;
}
.stepsoversionbl_inn-success span{
    display: none;
}
#version1{
    width: 25%;
}
.certblockoplata1{
    display: block;
    width: 200px;
    float: left;
}
.bodypartbtn2-mob{
    display: none;
}
.certblockoplata1inn{
    display: block;
    background: #FFF7E7;
    border-radius: 6px;
    padding: 19px;
    width: fit-content;
    margin: 0 auto;
}
.certblockoplata2{
    display: block;
    float: left;
    width: calc(100% - 200px);
    padding-left: 30px;
}
.certblockoplata1img{
    display: block;
    max-width: 100%;
    margin: 0 auto;
}
.certblockoplata2text{
    display: block;
    font-family: 'gilreg';
    font-size: 16px;
    color: #000000;
    margin: 0px 0px 30px;
}
.tolemblocktext3 span{
    font-family: 'gilsb';
    font-size: 14px;
    color: #FF0000;
}
.certnametitle{
    display: block;
    font-family: 'gilbd';
    font-size: 24px;
    color: #000000;
    margin: 0px 0px 10px;
}
.juktalushtxt{
    display: block;
    font-family: 'gilreg';
    font-size: 16px;
    color: #000000;
    margin:0px 0px 30px;
}
.juktalushtxtbtn2s{
    display: block;
    width: 200px;
    height: 40px;
    background: #1C77FD;
    border-radius: 6px;
    border:none;
    font-family: 'gilbd';
    font-size: 14px;
    color: #FFFFFF;
}
.juktalushtxtbtn2s img{
    margin-right: 10px;
}
.modal-content-delete-doc{
    display: block;
    background: #fff;
    padding: 40px 70px;
    position: relative;
}

.deltedoctitle{
    display: block;
    font-family: 'gilbd';
    font-size: 24px;
    color: #000000;
    margin: 0px 0px 5px;
}
.deltedoctitleunder{
    display: block;
    font-family: 'gilreg';
    font-size: 16px;
    color: #808080;
    margin:0px 0px 30px;
}
.matdellabel{
    display: block;
    font-family: 'gilreg';
    font-size: 16px;
    color: #000000;
    margin: 0px 0px 10px;
}
.deletedocordtext{
    display: block;
    background: #F8F8F8;
    border: 0.5px solid #909090;
    box-sizing: border-box;
    border-radius: 4px;    
    margin-bottom: 10px;
    width: 100%;
    max-width: 100%;
    height: 160px;
    max-height: 300px;
    padding: 15px;
    outline: none;
    font-family: 'gilreg';
    font-size: 14px;
}
.btndelorderbtn{
    display: block;
    background: #FFDBDB;
    border-radius: 6px;
    border:none;
    width: 200px;
    height: 40px;
    font-family: 'gilsb';
    font-size: 14px;
    color: #FF0000;
    transition: 0.3s all;
}
.btndelorderbtn span{
    margin-right: 10px;
}
.btndelorderbtn:hover{
    background: red;
    color:#fff;
}
.delordertextinfo{
    display: none;
    padding: 20px 20px 0px;
    background: #fff;
}
.deleteorder-info{
    display: block;
    background: #FFF7E7;
    border-radius: 6px;
    padding: 10px;
}
.trashsvg{
    display: block;
    float: left;
    margin-right: 10px;
}
.trashtext{
    display: block;
    font-family: 'gilsb';
    font-size: 16px;
    color: #FF8B0D;
    margin: 0px;
    float: left;
}
.infoupdate{
    display: block;
    padding: 40px 70px;
}
.matinfotextblbtns {
    display: block;
    font-size: 14px;
    margin-top: 15px;
    background: #03B113;
    border: none;
    width: 160px;
    height: 40px;
    border-radius: 6px;
    color: #fff;
    font-family: 'gilsb';
    transition: 0.3s all;
}
.matinfotextblbtns:hover{
    background:#0f7b19;
}
.tolem-successpayf{
    display: block;
    width: 200px;
    height: 40px;
    border: none;
    color: #fff;
    font-size: 14px;
    font-family: 'gilsb';
    background: #03b113ad;
    border-radius: 5px;
    outline: none;
    transition: 0.3s all;
}
.tolemblocktext3 a{
    color:#1C77FD;
    transition: 0.3s all;
}
.tolemblocktext3 a:hover{
    color: #254EE2;
}
.lgform-content{
    display: flex;
    flex-wrap: wrap;
    flex-direction: row;
    justify-content: space-between;
    align-items: stretch;
}
#lgform-content-2 .lgform-content{
    max-height: 800px;
    overflow: auto;
}
.lgformp1{
    display: block;
    width: 50%;
    padding: 40px;
    border-right: 1px solid #F1F1F1;
}
.lgformp2{
    display: block;
    width: 50%;
    padding: 40px;
}
.lgformp1txt1{
    display: block;
    margin: 0px 0px 20px;
    font-family: 'gilbd';
    font-size: 20px;
    color: #000000;
}
.lgformp2txt1{
    display: block;
    font-family: 'gilbd';
    font-size: 35px;
    color: #000000;
    margin: 30px 0px 10px;
}
.lgformp2txt2{
    display: block;
    font-family: 'gilreg';
    font-size: 16px;
    color: #000000;
    margin: 0px 0px 30px;
}
.lgformp2btn1{
    display: block;
    width: 100%;
    height: 50px;
    background: #EFF3FF;
    border-radius: 6px;
    font-family: 'gilsb';
    font-size: 14px;
    color: #1C77FD;
    border: none;
    outline: none;
    transition: 0.3s all;
}
.modal-content-auth{
    background: #fff;
    box-shadow: 0px 4px 5px 0px rgb(0 0 0 / 10%);
    border-radius: 6px;
    overflow: hidden;
    position: relative;
    margin-top:100px;
    pointer-events: all;
}
#modalShowauth{
    pointer-events: none;
}
.lgformp2btn1:hover{
    background: #254EE2;
    color:#fff;
}
.modal-content-auth{
    background: #fff;
    box-shadow: 0px 4px 5px 0px rgb(0 0 0 / 10%);
    border-radius: 6px;
    overflow: hidden;
    position: relative;
    margin-top:100px;
    pointer-events: all;
}
#modalShowauth{
    pointer-events: none;
}
</style>

    <div class="centered page-title width1088">
        <h1>@lang('auth.reg')</h1>
    </div>

<form id="w1" action="" class="registration centered width1088" method="post" enctype="multipart/form-data">
<input type="hidden" name="_csrf-frontend" value="fDzpC12FnG_lWdRIhZgU58ancKaRVIOAJWEJbzX4EF9Z2IkoXoyvuQIsJYw5FB0aC17rrEysyXeQx6_KsHXdOw==">                                    

                            <div class="form-blocks-zharialau marbt30">
                                <h4 class="matzharlabelsel">Текст</h4><div class="matlabelsinform"><div class="matlabinftext">Текст</div> </div>
                                <div class="clear"></div>
                                <div class="form-group field-doc-title required">

<input type="text" id="doc-title" class="matzhatnewinput" name="Doc[title]" maxlength="130" required="" placeholder="Текст" aria-required="true">

<div class="help-block"></div>
</div>                            </div>
                            <div class="form-blocks-zharialau marbt30">
                                <h4 class="matzharlabelsel">Текст</h4><div class="matlabelsinform"><div class="matlabinftext">Текст</div> </div>
                                <div class="clear"></div>
                                <div class="form-group field-doc-description required">

<textarea id="doc-description" class="matzhatnewtextarea" name="Doc[description]" required="" placeholder="Текст" aria-required="true"></textarea>

<div class="help-block"></div>
</div>                            </div>
                            <div class="form-blocks-zharialau marbt30">
                                <h4 class="matzharlabelsel">Текст</h4><div class="matlabelsinform"> <div class="matlabinftext">Текст</div> </div>
                                <div class="clear"></div>
                                <div class="form-group field-doc-ser_fio required">

<input type="text" id="doc-ser_fio" class="matzhatnewinput" name="Doc[ser_fio]" maxlength="150" required="" value="Текст" placeholder="Текст" aria-required="true">

<div class="help-block"></div>
</div>                            </div>
                            <div class="form-blocks-zharialau marbt30">
                                <h4 class="matzharlabelsel">Текст</h4>
                                <div class="matlabelsinform">
                                    <div class="matlabinftext">Текст <br>
                                        Текст <br>
                                        &nbsp;
                                    </div> 
                                </div>
                                <div class="clear"></div>
                                <div class="form-group field-doc-info required">

<input type="text" id="doc-info" class="matzhatnewinput" name="Doc[info]" maxlength="250" required="" value="Текст" placeholder="Текст" aria-required="true">

<div class="help-block"></div>
</div>                            </div>

                            <div class="form-blocks-zharialau-flex">
                                <div class="form-block-parts">
                                <h4 class="matzharlabelsel">Текст</h4>
                                <div class="clear"></div>
                                <div class="form-group field-doc-zhanr required">

<select id="doc-zhanr" class="matzharlists" name="Doc[zhanr]" required="" aria-required="true">
<option value="">Текст</option>
<option value="Барлық пәндер ">Текст </option>
</select>

<div class="help-block"></div>
</div>                                </div>
                                <div class="form-block-parts">
                                <h4 class="matzharlabelsel">Текст</h4>
                                <div class="clear"></div>
                                <div class="form-group field-doc-zhanr2 required">

<select id="doc-zhanr2" class="matzharlists" name="Doc[zhanr2]" required="" aria-required="true">
<option value="">Текст</option>
<option value="Барлық материалдар ">Текст </option>
</select>

<div class="help-block"></div>
</div>                                </div>
                                <div class="form-block-parts">
                                <h4 class="matzharlabelsel">Текст</h4>
                                <div class="clear"></div>
                                <div class="form-group field-doc-zhanr3 required">

<select id="doc-zhanr3" class="matzharlists" name="Doc[zhanr3]" required="" aria-required="true">
<option value="">Текст</option>
<option value="Барлық сыныптар">Текст</option>
</select>

<div class="help-block"></div>
</div>                                </div>
                            </div>
                            <div class="form-blocks-zharialau marbt30">
                                <h4 class="matzharlabelsel">Текст</h4><div class="matlabelsinform"><div class="matlabinftext">Текст</div> </div>
                                <div class="clear"></div>
                                <div class="matzharzhetbtns mtzx1" onclick="setzhetekshi_mat(1)">Текст</div>
                                <div class="matzharzhetbtns mtzx2" onclick="setzhetekshi_mat(2)">Текст</div>
                            </div>
                            <div class="form-blocks-zharialau marbt30 zhetekshimatzharbt">
                                <h4 class="matzharlabelsel">Текст</h4><div class="matlabelsinform">? <div class="matlabinftext">Текст</div> </div><h4 class="mindettiemestext">Текст</h4>
                                <div class="clear"></div>
                                <div class="form-group field-doc-zhetekshi">

<input type="text" id="doc-zhetekshi" class="matzhatnewinput" name="Doc[zhetekshi]" placeholder="мысалы: Асланов Жандос Ғаниұлы">

<div class="help-block"></div>
</div>                            </div>
                            <div class="form-blocks-zharialau marbt30">
                                <h4 class="matzharlabelsel">Выбрать файл</h4><div class="matlabelsinform"><div class="matlabinftext">Ворд, презентация және пдф файлдары қабылданады. Видеосабақтар, архив файлдар, фотолар қабылданбайды. <br>doc, docx, ppt, pptx, pdf
</div> </div>
                                <div class="clear"></div>
                                <div class="fileinputform">
                                    <div class="fileinputform2">
                                        <svg id="upload_matzhar"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 300" width="300" height="300" preserveAspectRatio="xMidYMid meet" style="width: 100%; height: 100%; transform: translate3d(0px, 0px, 0px);"><defs><clipPath id="__lottie_element_5"><rect width="300" height="300" x="0" y="0"></rect></clipPath></defs><g clip-path="url(#__lottie_element_5)"><g transform="matrix(1,0,0,1,76.66199493408203,98.28499603271484)" opacity="1" style="display: block;"><g opacity="1" transform="matrix(1,0,0,1,71.95899963378906,50.01100158691406)"><path stroke-linecap="butt" stroke-linejoin="miter" fill-opacity="0" stroke-miterlimit="10" stroke="rgb(28,119,253)" stroke-opacity="1" stroke-width="3" d=" M13.12399959564209,42.5099983215332 C28.992000579833984,42.5099983215332 42.448001861572266,42.5099983215332 42.448001861572266,42.5099983215332 C42.448001861572266,42.5099983215332 42.448001861572266,42.505001068115234 42.448001861572266,42.505001068115234 C54.62099838256836,42.402000427246094 64.45999908447266,32.50600051879883 64.45999908447266,20.308000564575195"></path></g><g opacity="1" transform="matrix(1,0,0,1,71.95899963378906,50.01100158691406)"><path stroke-linecap="butt" stroke-linejoin="miter" fill-opacity="0" stroke-miterlimit="10" stroke="rgb(28,119,253)" stroke-opacity="1" stroke-width="3" d=" M64.45999908447266,20.308000564575195 C64.45999908447266,9.201000213623047 56.30099868774414,-0.0020000000949949026 45.650001525878906,-1.6349999904632568 C45.90700149536133,-2.8589999675750732 46.042999267578125,-4.125 46.042999267578125,-5.423999786376953 C46.042999267578125,-15.595000267028809 37.797000885009766,-23.840999603271484 27.625999450683594,-23.840999603271484 C25.07699966430664,-23.840999603271484 22.649999618530273,-23.323999404907227 20.44300079345703,-22.38800048828125 C15.189000129699707,-34.2400016784668 3.3289999961853027,-42.5099983215332 -10.470000267028809,-42.5099983215332 C-29.141000747680664,-42.5099983215332 -44.275001525878906,-27.375999450683594 -44.275001525878906,-8.704999923706055 C-44.275001525878906,-8.282999992370605 -44.2599983215332,-7.866000175476074 -44.244998931884766,-7.447999954223633 C-55.7760009765625,-5.123000144958496 -64.45999908447266,5.064000129699707 -64.45999908447266,17.2810001373291 C-64.45999908447266,31.214000701904297 -53.165000915527344,42.5099983215332 -39.231998443603516,42.5099983215332 C-38.637001037597656,42.5099983215332 -38.04899978637695,42.481998443603516 -37.46500015258789,42.44200134277344 C-37.46500015258789,42.44200134277344 -37.46500015258789,42.5099983215332 -37.46500015258789,42.5099983215332 C-37.46500015258789,42.5099983215332 -27.8700008392334,42.5099983215332 -15.329000473022461,42.5099983215332"></path></g><g opacity="1" transform="matrix(1,0,0,1,70.82599639892578,56.28139877319336)"><path stroke-linecap="butt" stroke-linejoin="miter" fill-opacity="0" stroke-miterlimit="10" stroke="rgb(28,119,253)" stroke-opacity="1" stroke-width="3" d=" M-18.41699981689453,7.573999881744385 C-18.41699981689453,7.573999881744385 0.0020000000949949026,-7.573999881744385 0.0020000000949949026,-7.573999881744385 C0.0020000000949949026,-7.573999881744385 18.41699981689453,7.573999881744385 18.41699981689453,7.573999881744385"></path></g><g opacity="1" transform="matrix(1,0,0,1,0,-6.9895782470703125)"><path stroke-linecap="butt" stroke-linejoin="miter" fill-opacity="0" stroke-miterlimit="10" stroke="rgb(28,119,253)" stroke-opacity="1" stroke-width="3" d=" M70.82599639892578,112.94499969482422 C70.82599639892578,112.94499969482422 70.82599639892578,57.452999114990234 70.82599639892578,57.452999114990234"></path></g></g></g></svg></svg>
                                        <h4 class="matfileextensions">doc, docx, ppt, pptx, pdf <span></span></h4> 
                                        <h4 class="filedownload_h4">Выберите файл</h4>
                                    </div>
                                    <div class="matzharloader">
                                        <h4 class="matzharproc"><span id="procofp">0</span>% загружено...</h4>
                                        <div class="lineload">
                                            <div class="lineload2"></div>
                                        </div>
                                        <h4 class="matnameforsc" id="file-name-matz">Файл урока</h4>
                                    </div>
                                    <div class="donematzhcl">
                                        <svg id="done_matzhar"></svg>
                                        <h4 class="donematzhtext">Ваш файл успешно загружен</h4>
                                        <div class="filesdonematzhd">
                                            <h4 class="matfilenamelike" id="file-name-matz2">Файл урока.pdf</h4>
                                            <h4 class="fileozgerttype"><img src="./Материал жариялау_files/pen.svg" alt="" class="ozgpenmatzh"> Өзгерту</h4>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                    <div class="form-group field-uploaded-file1 required">

<input type="hidden" name="Doc[file_doc1]" value=""><input type="file" id="uploaded-file1" class="fileinputmatzhar" name="Doc[file_doc1]" onchange="getFileParam()" required="" aria-required="true">

<div class="help-block"></div>
</div>                                </div>
                            </div>
                            <div class="clear"></div>
                                                        <div class="matzhar_by_btnn" onclick="materdownloadlogin()" style="text-align: center;padding-top: 13px; cursor:pointer;">Текст</div>
                                                        <h4 class="btnmatzhartext">Текст<br><span class="matzharrulesfor" onclick="showerezhe()">&nbsp;</span><br>&nbsp;</h4>
                            </form>

@endsection