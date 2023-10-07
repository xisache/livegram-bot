<?php

ob_start();
define('API_KEY','BOT TOKENI');
echo "https://api.telegram.org/bot" . API_KEY . "/setwebhook?url=" . $_SERVER['SERVER_NAME'] . "" . $_SERVER['SCRIPT_NAME'];
$admin ="ADMIN ID";

function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}

    function open($str){
    return file_get_contents($str);
    }
    
    function save($str,$to){
    file_put_contents($str,$to);
    }

$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$text = $message->text;
$chat_id = $message->chat->id;
$reply_text = $message->reply_to_message->text;
$user_id = $message->from->id;
$name = $message->from->first_name;
$id = $message->from->id;
@mkdir("sys");
$reply_menu = json_encode([
           'resize_keyboard'=>false,
            'force_reply' => true,
            'selective' => true
        ]);

if($text == "/start"){
if(strpos(open("sys/users.ID"),"$chat_id")!==false){
}else{
save("sys/users.ID",open("sys/users.ID")."\n$chat_id");
}
}

$ma=file_get_contents("sys/users.ID");
$sm = explode("\n",$ma);
$cn = count($sm);

if($text=="/stat"){
    bot("SendMessage",[ 
    'chat_id'=>$chat_id,
    'text'=>"*🤖Botdagi jami a'zo:* _$cn-ta_",
    "parse_mode"=>'markdown',
]);
return false;
}

mkdir("mid");
if ($text==$text and $chat_id <> $admin){ 
if($text == "/start"){
}else{
    $mid5=bot('ForwardMessage',[
        'chat_id'=>$admin,
        'from_chat_id'=>$chat_id,
        'message_id'=>$message->message_id,
        ])->result->message_id;
        $mid=$message->message_id;
        file_put_contents("mid/$mid5.txt","$chat_id|$mid");
}
}

if($message->reply_to_message->message_id and $user_id == $admin){
$rchid=$message->reply_to_message->message_id;
$chid=file_get_contents("mid/$rchid.txt");
$ex=explode ("|",$chid);
    bot('SendMessage',[
       'chat_id'=>$ex[0],
        'text'=>"<b>$text</b>",
        "parse_mode"=>'html',
    ]);
}

if($text=="/start"){
    bot("SendMessage",[ 
    'chat_id'=>$chat_id,
    'text'=>"<b>👋🏻Assalomu alaykum</b>\n\n<i>ℹ️Savol va takliflaringiz bo`lsa yozib qoldiring men albatta javob beraman!</i>",
    "parse_mode"=>'html',
]);
return false;
}