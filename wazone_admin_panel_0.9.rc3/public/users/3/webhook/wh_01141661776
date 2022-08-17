<?php
header('content-type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$receiver = $data['receiver'];
$appurl = $data['appurl'];
$text = $data['text'];
$keyword =strtolower($text);

switch ($keyword) {
    case "!chat":
        $chatMessage = ['text' => "Hello {name}... This is a message in regular chat mode"];
        $result = ['data' => $chatMessage];
        break;

    case "!list":
        $rows1 = [
            ['title' => 'Row 1', 'description' => 'Hello its description 1', 'rowId' => 'rowid1'],
            ['title' => 'Row 2', 'description' => 'Hello its description 2', 'rowId' => 'rowid2']
        ];
        $rows2 = [
            ['title' => 'Row 3', 'description' => 'Hello its description 3', 'rowId' => 'rowid3'],
            ['title' => 'Row 4', 'description' => 'Hello its description 4', 'rowId' => 'rowid4']
        ];
        $sections = [['title' => 'Section 1', 'rows' => $rows1],
            ['title' => 'Section 2', 'rows' => $rows2],
        ];
        $listMessage = [
            'text' => "This is a list",
            'footer' => "nice footer, link: https://google.com",
            'title' => "Amazing boldfaced list title",
            'buttonText' => "Required, text on the button to view the list",
            'sections' => $sections,
        ];
        $result = ['data' => $listMessage];
        break;

    case "!template":
        $templateButtons  = [
            ['index' => '1', 'urlButton' => ['displayText' => '⭐ Star Baileys on GitHub!', 'url' => 'https://github.com/adiwajshing/Baileys']],
            ['index' => '2', 'callButton' => ['displayText' => 'Call me!', 'phoneNumber' => '+1 (234) 5678-901']],
            ['index' => '3', 'quickReplyButton' => ['displayText' => 'This is a reply, just like normal buttons!', 'id' => 'test']],
        ];
        $templateMessage  = [
            'text' => 'Hi its template  message',
            'footer' => 'Hello World',
            'templateButtons' => $templateButtons,
        ];
        $result = ['data' => $templateMessage];
        break;

    case "!button":
        $buttons = [
            ['buttonId' => 'id1', 'buttonText' => ['displayText' => 'Cucumbers'], 'type' => 1],
            ['buttonId' => 'id2', 'buttonText' => ['displayText' => 'Tomatoes'], 'type' => 1],
            ['buttonId' => 'id3', 'buttonText' => ['displayText' => 'Lettuce'], 'type' => 1],
        ];
        $buttonMessage = [
            'image' => ['url' => "{$appurl}/public/app-assets/images/app/fruits.png"],
            'caption' => 'Which of these is not a fruit?',
            'footerText' => 'Hello World',
            'buttons' => $buttons,
            'headerType' => 4,
        ];
        $result = ['data' => $buttonMessage];
        break;

    case "!image":
        $imageMessage = [
            'image' => ['url' => 'https://i.ytimg.com/vi/gUIJ-UkQsXI/maxresdefault.jpg'],
            'caption' => 'Hello {name}... this is a webhook picture from the web url',
        ];
        $result = ['data' => $imageMessage];
        break;

    case "!gif":
        $imageMessage = [
            'image' => ['url' => "{$appurl}/public/app-assets/images/app/walking.gif"],
            'caption' => 'Hello {name}... this is a webhook picture from local storage',
        ];
        $result = ['data' => $imageMessage];
        break;

    default:
        // if no match, do nothing!
}

if (!empty($result)) echo json_encode($result);