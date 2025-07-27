<?php
ignore_user_abort(true);
set_time_limit(0);
ini_set("memory_limit", "320M");

// ✅ TELEGRAM CONFIG
$BOT_TOKEN = "7821825228:AAFJ8cNTGc47Ia-YRisL_ujDKc-lYYUc_Nw";
$CHAT_ID = "-1002052531109";

// ✅ IVASMS Cookie & Token
$XSRF_TOKEN = "eyJpdiI6IllSeW9aamRSNEFpcXFPL2tYV0laOXc9PSIsInZhbHVlIjoiRlo1OUdrbzhzWlZIQjVhSkFkRlhjbHZUdlBxOVNYNTE1M2ZySjZPVnVrTlZVTEJXSENHQ3lUWVd1S2l4c0lJLzJKOU9aWGFCMkxpMGdTV2FScDFnTmh2d1FNaTdwcHdjZzlPTEFhRWJsNklOMk8waGhJenFJM3A4Z3p3TXg3M2UiLCJtYWMiOiI1NjAxODllYzdiYzc0MzBmYWZmOWQ4MGUwOTk4YzQ2MzhmOWE1ZWY0NTI1MmVlMDA2MmY2ZDBkODUwNGVjMWY2IiwidGFnIjoiIn0%3D";

$COOKIES = "_fbp=fb.1.1753150366246.18115314181512568; XSRF-TOKEN=$XSRF_TOKEN; ivas_sms_session=eyJpdiI6ImFvK29uNUI1WEJWU0wrV0pQa3JZZUE9PSIsInZhbHVlIjoiQXFwTnpPNE5MTGZzMzJ1MFhWbHBNRXpnUzNLZmRQbThhYkVxNlFId3gyc0RLYThNN05RWWJaVjl1dVgvWFZNajZJcUkxc3JmalFCdEx5dk9aZDZNMjQ1bzRNNjdac1dCTFIzU3VRR01LUFRDbUdlY09xSGtPamtPUXVlVjZIV1giLCJtYWMiOiI0MzEzMzVkMmUzMjBiYWUwNThjMzdhOTA4ZDFmOTMwMzA1NWQ2MDA0NzJkNDdlNjZiNDc5NjE2NWNjZjBiM2EzIiwidGFnIjoiIn0%3D";

// ✅ KEEP SESSION ALIVE
function keepSessionAlive() {
    global $COOKIES, $XSRF_TOKEN;
    $url = "https://www.ivasms.com/portal/sms/received";
    $headers = [
        "Cookie: $COOKIES",
        "X-XSRF-TOKEN: $XSRF_TOKEN",
        "User-Agent: Mozilla/5.0"
    ];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}

// ✅ TELEGRAM SENDER: প্রতি ১১ সেকেন্ডে ১টা করে মেসেজ পাঠাবে
function sendTelegramBatch($messages) {
    global $BOT_TOKEN, $CHAT_ID;

    foreach ($messages as $msg) {
        $url = "https://api.telegram.org/bot$BOT_TOKEN/sendMessage";
        $data = [
            "chat_id" => $CHAT_ID,
            "text" => $msg,
            "parse_mode" => "HTML",
            "disable_web_page_preview" => true
        ];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);

        sleep(11); // ← এখানে একেক মেসেজের মাঝে ১১ সেকেন্ড বিরতি হবে
    }
}

// ✅ COUNTRY DETECTOR
function getCountry($number) {
    $prefixes = [
        "1" => ["𝑼𝒏𝒊𝒕𝒆𝒅 𝑺𝒕𝒂𝒕𝒆𝒔", "🇺🇸"],
  "7" => ["𝑹𝒖𝒔𝒔𝒊𝒂", "🇷🇺"],
  "20" => ["𝑬𝒈𝒚𝒑𝒕", "🇪🇬"],
  "27" => ["𝑺𝒐𝒖𝒕𝒉 𝑨𝒇𝒓𝒊𝒄𝒂", "🇿🇦"],
  "30" => ["𝑮𝒓𝒆𝒆𝒄𝒆", "🇬🇷"],
  "31" => ["𝑵𝒆𝒕𝒉𝒆𝒓𝒍𝒂𝒏𝒅𝒔", "🇳🇱"],
  "32" => ["𝑩𝒆𝒍𝒈𝒊𝒖𝒎", "🇧🇪"],
  "33" => ["𝑭𝒓𝒂𝒏𝒄𝒆", "🇫🇷"],
  "34" => ["𝑺𝒑𝒂𝒊𝒏", "🇪🇸"],
  "36" => ["𝑯𝒖𝒏𝒈𝒂𝒓𝒚", "🇭🇺"],
  "39" => ["𝑰𝒕𝒂𝒍𝒚", "🇮🇹"],
  "40" => ["𝑹𝒐𝒎𝒂𝒏𝒊𝒂", "🇷🇴"],
  "41" => ["𝑺𝒘𝒊𝒕𝒛𝒆𝒓𝒍𝒂𝒏𝒅", "🇨🇭"],
  "43" => ["𝑨𝒖𝒔𝒕𝒓𝒊𝒂", "🇦🇹"],
  "44" => ["𝑼𝒏𝒊𝒕𝒆𝒅 𝑲𝒊𝒏𝒈𝒅𝒐𝒎", "🇬🇧"],
  "45" => ["𝑫𝒆𝒏𝒎𝒂𝒓𝒌", "🇩🇰"],
  "46" => ["𝑺𝒘𝒆𝒅𝒆𝒏", "🇸🇪"],
  "47" => ["𝑵𝒐𝒓𝒘𝒂𝒚", "🇳🇴"],
  "48" => ["𝑷𝒐𝒍𝒂𝒏𝒅", "🇵🇱"],
  "49" => ["𝑮𝒆𝒓𝒎𝒂𝒏𝒚", "🇩🇪"],
  "51" => ["𝑷𝒆𝒓𝒖", "🇵🇪"],
  "52" => ["𝑴𝒆𝒙𝒊𝒄𝒐", "🇲🇽"],
  "53" => ["𝑪𝒖𝒃𝒂", "🇨🇺"],
  "54" => ["𝑨𝒓𝒈𝒆𝒏𝒕𝒊𝒏𝒂", "🇦🇷"],
  "55" => ["𝑩𝒓𝒂𝒛𝒊𝒍", "🇧🇷"],
  "56" => ["𝑪𝒉𝒊𝒍𝒆", "🇨🇱"],
  "57" => ["𝑪𝒐𝒍𝒐𝒎𝒃𝒊𝒂", "🇨🇴"],
  "58" => ["𝑽𝒆𝒏𝒆𝒛𝒖𝒆𝒍𝒂", "🇻🇪"],
  "60" => ["𝑴𝒂𝒍𝒂𝒚𝒔𝒊𝒂", "🇲🇾"],
  "61" => ["𝑨𝒖𝒔𝒕𝒓𝒂𝒍𝒊𝒂", "🇦🇺"],
  "62" => ["𝑰𝒏𝒅𝒐𝒏𝒆𝒔𝒊𝒂", "🇮🇩"],
  "63" => ["𝑷𝒉𝒊𝒍𝒊𝒑𝒑𝒊𝒏𝒆𝒔", "🇵🇭"],
  "64" => ["𝑵𝒆𝒘 𝒁𝒆𝒂𝒍𝒂𝒏𝒅", "🇳🇿"],
  "65" => ["𝑺𝒊𝒏𝒈𝒂𝒑𝒐𝒓𝒆", "🇸🇬"],
  "66" => ["𝑻𝒉𝒂𝒊𝒍𝒂𝒏𝒅", "🇹🇭"],
  "81" => ["𝑱𝒂𝒑𝒂𝒏", "🇯🇵"],
  "82" => ["𝑺𝒐𝒖𝒕𝒉 𝑲𝒐𝒓𝒆𝒂", "🇰🇷"],
  "84" => ["𝑽𝒊𝒆𝒕𝒏𝒂𝒎", "🇻🇳"],
  "86" => ["𝑪𝒉𝒊𝒏𝒂", "🇨🇳"],
"90" => ["𝑻𝒖𝒓𝒌𝒆𝒚", "🇹🇷"],
  "91" => ["𝑰𝒏𝒅𝒊𝒂", "🇮🇳"],
  "92" => ["𝑷𝒂𝒌𝒊𝒔𝒕𝒂𝒏", "🇵🇰"],
  "93" => ["𝑨𝒇𝒈𝒉𝒂𝒏𝒊𝒔𝒕𝒂𝒏", "🇦🇫"],
  "94" => ["𝑺𝒓𝒊 𝑳𝒂𝒏𝒌𝒂", "🇱🇰"],
  "95" => ["𝑴𝒚𝒂𝒏𝒎𝒂𝒓", "🇲🇲"],
  "98" => ["𝑰𝒓𝒂𝒏", "🇮🇷"],
  "211" => ["𝑺𝒐𝒖𝒕𝒉 𝑺𝒖𝒅𝒂𝒏", "🇸🇸"],
  "212" => ["𝑴𝒐𝒓𝒐𝒄𝒄𝒐", "🇲🇦"],
  "213" => ["𝑨𝒍𝒈𝒆𝒓𝒊𝒂", "🇩🇿"],
  "216" => ["𝑻𝒖𝒏𝒊𝒔𝒊𝒂", "🇹🇳"],
  "218" => ["𝑬𝒄𝒖𝒂𝒅𝒐𝒓", "🇪🇨"],
  "220" => ["𝑮𝒂𝒎𝒃𝒊𝒂", "🇬🇲"],
  "221" => ["𝑺𝒆𝒏𝒆𝒈𝒂𝒍", "🇸🇳"],
  "222" => ["𝑴𝒂𝒖𝒓𝒊𝒕𝒂𝒏𝒊𝒂", "🇲🇷"],
  "223" => ["𝑴𝒂𝒍𝒊", "🇲🇱"],
  "224" => ["𝑮𝒖𝒊𝒏𝒆𝒂", "🇬🇳"],
  "225" => ["𝑪𝒐𝒕𝒆 𝑫’𝑰𝒗𝒐𝒊𝒓𝒆", "🇨🇮"],
  "226" => ["𝑩𝒖𝒓𝒌𝒊𝒏𝒂 𝑭𝒂𝒔𝒐", "🇧🇫"],
  "227" => ["𝑵𝒊𝒈𝒆𝒓", "🇳🇪"],
  "228" => ["𝑻𝒐𝒈𝒐", "🇹🇬"],
  "229" => ["𝑩𝒆𝒏𝒊𝒏", "🇧🇯"],
  "230" => ["𝑴𝒂𝒖𝒓𝒊𝒕𝒊𝒖𝒔", "🇲🇺"],
  "231" => ["𝑳𝒊𝒃𝒆𝒓𝒊𝒂", "🇱🇷"],
  "232" => ["𝑺𝒊𝒆𝒓𝒓𝒂 𝑳𝒆𝒐𝒏𝒆", "🇸🇱"],
  "233" => ["𝑮𝒉𝒂𝒏𝒂", "🇬🇭"],
  "234" => ["𝑵𝒊𝒈𝒆𝒓𝒊𝒂", "🇳🇬"],
  "235" => ["𝑪𝒉𝒂𝒅", "🇹🇩"],
  "236" => ["𝑪𝒆𝒏𝒕𝒓𝒂𝒍 𝑨𝒇𝒓𝒊𝒄𝒂𝒏 𝑹𝒆𝒑𝒖𝒃𝒍𝒊𝒄", "🇨🇫"],
  "237" => ["𝑪𝒂𝒎𝒆𝒓𝒐𝒐𝒏", "🇨🇲"],
  "238" => ["𝑪𝒂𝒑𝒆 𝑽𝒆𝒓𝒅𝒆", "🇨🇻"],
  "239" => ["𝑺𝒂𝒐 𝑻𝒐𝒎𝒆 & 𝑷𝒓𝒊𝒏𝒄𝒊𝒑𝒆", "🇸🇹"],
  "240" => ["𝑬𝒒𝒖𝒂𝒕𝒐𝒓𝒊𝒂𝒍 𝑮𝒖𝒊𝒏𝒆𝒂", "🇬🇶"],
  "241" => ["𝑮𝒂𝒃𝒐𝒏", "🇬🇦"],
  "242" => ["𝑹𝒆𝒑. 𝒐𝒇 𝑪𝒐𝒏𝒈𝒐", "🇨🇬"],
  "243" => ["𝑫𝑹 𝑪𝒐𝒏𝒈𝒐", "🇨🇩"],
  "244" => ["𝑨𝒏𝒈𝒐𝒍𝒂", "🇦🇴"],
  "245" => ["𝑮𝒖𝒊𝒏𝒆𝒂-𝑩𝒊𝒔𝒔𝒂𝒖", "🇬🇼"],
  "246" => ["𝑫𝒊𝒆𝒈𝒐 𝑮𝒂𝒓𝒄𝒊𝒂", "🇮🇴"],
  "247" => ["𝑺𝒕. 𝑯𝒆𝒍𝒆𝒏𝒂", "🇸🇭"],
  "248" => ["𝑺𝒆𝒚𝒄𝒉𝒆𝒍𝒍𝒆𝒔", "🇸🇨"],
  "249" => ["𝑺𝒖𝒅𝒂𝒏", "🇸🇩"],
  "250" => ["𝑹𝒘𝒂𝒏𝒅𝒂", "🇷🇼"],
  "251" => ["𝑬𝒕𝒉𝒊𝒐𝒑𝒊𝒂", "🇪🇹"],
  "252" => ["𝑺𝒐𝒎𝒂𝒍𝒊𝒂", "🇸🇴"],
  "253" => ["𝑫𝒋𝒊𝒃𝒐𝒖𝒕𝒊", "🇩🇯"],
  "254" => ["𝑲𝒆𝒏𝒚𝒂", "🇰🇪"],
  "256" => ["𝑼𝒈𝒂𝒏𝒅𝒂", "🇺🇬"],
  "257" => ["𝑩𝒖𝒓𝒖𝒏𝒅𝒊", "🇧🇮"],
  "258" => ["𝑴𝒐𝒛𝒂𝒎𝒃𝒊𝒒𝒖𝒆", "🇲🇿"],
  "260" => ["𝒁𝒂𝒎𝒃𝒊𝒂", "🇿🇲"],
  "261" => ["𝑴𝒂𝒅𝒂𝒈𝒂𝒔𝒄𝒂𝒓", "🇲🇬"],
  "262" => ["𝑹𝒆𝒖𝒏𝒊𝒐𝒏", "🇷🇪"],
  "263" => ["𝒁𝒊𝒎𝒃𝒂𝒃𝒘𝒆", "🇿🇼"],
  "264" => ["𝑵𝒂𝒎𝒊𝒃𝒊𝒂", "🇳🇦"],
  "265" => ["𝑴𝒂𝒍𝒂𝒘𝒊", "🇲🇼"],
  "266" => ["𝑳𝒆𝒔𝒐𝒕𝒉𝒐", "🇱🇸"],
  "267" => ["𝑩𝒐𝒕𝒔𝒘𝒂𝒏𝒂", "🇧🇼"],
  "268" => ["𝑬𝒔𝒘𝒂𝒕𝒊𝒏𝒊", "🇸🇿"],
  "269" => ["𝑪𝒐𝒎𝒐𝒓𝒐𝒔", "🇰🇲"],
  "290" => ["𝑺𝒕. 𝑯𝒆𝒍𝒆𝒏𝒂", "🇸🇭"],
  "291" => ["𝑬𝒓𝒊𝒕𝒓𝒆𝒂", "🇪🇷"],
"255" => ["𝑻𝒂𝒏𝒛𝒂𝒏𝒊𝒂", "🇹🇿"],
        // ... add more if needed
    ];
    foreach ($prefixes as $prefix => $info) {
        if (strpos($number, $prefix) === 0) return $info;
    }
    return ["Unknown", "🌍"];
}

// ✅ OTP EXTRACTOR
function extractOTP($text) {
    if (preg_match('/\b\d{3,4}[-\s]?\d{3,4}\b/', $text, $m)) return str_replace([' ', '-'], '', $m[0]);
    if (preg_match('/\b\d{6,8}\b/', $text, $m)) return $m[0];
    if (preg_match('/\b\d{3,5}\b/', $text, $m)) return $m[0];
    return "N/A";
}

// ✅ LIVE SMS SCRAPER
function scrapeLiveSMS() {
    global $COOKIES, $XSRF_TOKEN;
    $url = "https://www.ivasms.com/portal/live/test_sms";
    $headers = [
        "Cookie: $COOKIES",
        "X-XSRF-TOKEN: $XSRF_TOKEN",
        "User-Agent: Mozilla/5.0"
    ];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $html = curl_exec($ch);
    curl_close($ch);

    preg_match_all('/<tr class="border-bottom.*?<\/tr>/s', $html, $rows);
    $messagesToSend = [];

    foreach ($rows[0] as $row) {
        preg_match('/CopyText">(\d+)<\/p>/', $row, $num);
        preg_match('/fw-semi-bold ms-2">([^<]+)/', $row, $srv);
        preg_match('/fw-semi-bold">([^<]+)<\/td>/', $row, $msg);
        preg_match('/TerminationDetials\((\d+)\)/', $row, $rid);
        preg_match('/<h6[^>]*>([^<]+)<\/h6>/', $row, $rname);

        $number    = $num[1] ?? '';
        $service   = $srv[1] ?? 'Unknown';
        $message   = html_entity_decode($msg[1] ?? '');
        $rangeID   = $rid[1] ?? 'N/A';
        $rangeName = trim($rname[1] ?? 'N/A');

        if (!$number || !$message) continue;

        list($country, $flag) = getCountry($number);
        $otp = extractOTP($message);
        $now = date("Y-m-d H:i:s");

        $text = "<b>☄️ 𝑶𝑻𝑷 𝑺𝑰𝑮𝑵𝑨𝑳 𝑫𝑬𝑻𝑬𝑪𝑻𝑬𝑫 ☄️</b>\n\n" .
                "<blockquote>⏱️ 𝑻𝒊𝒎𝒆: <code>$now</code></blockquote>\n" .
                "<blockquote>🗺️ 𝑪𝒐𝒖𝒏𝒕𝒓𝒚: <code>$country</code> $flag</blockquote>\n" .
                "<blockquote>📡 𝑺𝒆𝒓𝒗𝒊𝒄𝒆: <code>$service</code></blockquote>\n" .
                "<blockquote>📲 𝑵𝒖𝒎𝒃𝒆𝒓: <code>$number</code></blockquote>\n" .
                "<blockquote>🧩 𝑹𝑨𝑵𝑮𝑬 𝑰𝑫: <code>$rangeID</code></blockquote>\n" .
                "<blockquote>🌊 𝑹𝑨𝑵𝑮𝑬 𝑵𝑨𝑴𝑬: <code>$rangeName</code></blockquote>\n" .
                "<blockquote>📨 𝐅𝐮𝐥𝐥 𝗠𝗮𝘀𝘀𝗮𝗴𝗲:</blockquote>\n" .
                "<blockquote><code>$message</code></blockquote>";

        $messagesToSend[] = $text;
    }

    if (!empty($messagesToSend)) {
        sendTelegramBatch($messagesToSend);
    }
}

// ✅ MAIN EXECUTION
keepSessionAlive();
scrapeLiveSMS();