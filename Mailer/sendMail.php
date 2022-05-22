<?php
    // @session_start();
    @$callback=$_GET['callback'];
    function fillPost($keys,$exclude = null){
        $array = array();
        foreach ($_REQUEST as $key=>$val){
            if (is_array($keys)){
                if (in_array($key, $keys)){
                    $array[$key] = $val;
                }
            }elseif($keys=="ALL"){
                if (isset($exclude)){
                    if(is_array($exclude)){
                        if (!in_array($key, $exclude)) {
                            $array[$key] = $val;
                        }
                    }else{
                        if ($key != $exclude) {
                            $array[$key] = $val;
                        }
                    }
                }else{
                    $array[$key] = $val;
                }
            }else{
                return $_REQUEST[$keys];
            }
        }
        return $array;
    }

    @$variables = fillPost('ALL');

    if(@($variables['Nombre'] && $variables['Correo'] && $variables['Page'])){
    //configuracion de correo
        @$httphost=getenv("HTTP_HOST").$variables['Page'];
        @$client = "engel-arm.com";
        @$sitioWeb = $httphost;
        @$sendTo = "edgar.edgarroman@gmail.com";
        // @$sendTo = "hosting2.0@outlook.com";

        @$combo="";
        @$linea="";
        foreach ($variables as $clave => $valor) {
            if(strpos($clave,'Lada')=='Lada'){
                @$linea .= substr($clave,0).": <strong>(". $valor .")</strong> ";
            }elseif(strpos($clave,'Mensaje')=='Mensaje'){
                @$linea .= " ".substr($clave,0).": <strong> ". $valor ." </strong><br>\r\n";
            }elseif(strpos($clave,'Page')=='Page'){
                @$linea.= "<br><br>Fecha enviado: <strong> ".date("F j, Y, g:i a")."</strong><br>\r\n";
                @$linea.="IP: <strong> ".getenv("REMOTE_ADDR")."</strong><br>\r\n";
                @$linea.="Host: <strong> ".$httphost."</strong><br>\r\n";
                @$linea.="Page: <strong> ".$valor."</strong><br>\r\n";
                @$linea.="Agent: <strong> ".getenv("HTTP_USER_AGENT")."</strong><br>\r\n";
            }else{
                @$linea.=substr($clave,0).": <strong> ". $valor ."</strong><br>\r\n";
            }
           // @$combo=$combo.$linea;
        }
        
        @$combo=$linea;
        if(@$variables['Contacto']){
            @$remitente=$variables['Contacto'];
        }else if(@$variables['Nombre']){
            @$remitente=$variables['Nombre'];
        }else if(@$variables['Empresa']){
            @$remitente=$variables['Empresa'];
        }else{
            @$remitente="";
        }
        @$asunto = "Contacto sitio web: ".$httphost;
        @$bodyMail = "<h3>Mensaje enviado desde formulario p&aacute;gina web  $sitioWeb</h3>".$combo;

        @$headers = "MIME-Version: 1.0" . "\r\n";
        @$headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
        @$headers .= "Reply-To: ".$variables['Correo']."\r\n";
        @$headers .= "From: $remitente <".$variables['Correo'].">\r\n"; 
        // @$headers .= "Bcc: " . "\r\n";

        if(@mail($sendTo,$asunto,$bodyMail,$headers)){
            @$RJason=1;
        }else{
            @$RJason=0;
            echo(getenv("HTTP_HOST"));
        }
    } else{
       
        @$RJason=9;
    }
    if(isset($callback)){
        echo $callback.'('.json_encode($RJason).')';
    }    
?>