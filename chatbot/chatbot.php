<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Chatbot</title>
    <link href="../chatbot/assets/chatbot.css" rel="stylesheet">
</head>
<body>
    <div class="chatbot-button" onclick="toggleAIChat()">
        <img src="../assets/img/chatbot/chatbot23.jpg" alt="Chatbot" class="chatbot-icon">
    </div>

    <div class="ai-chat-container" id="aiChatContainer" style="display: none;">
        <div class="ai-chat-header">
            <span>AI Chatbot - Hỗ trợ tư vấn</span>
            <button onclick="toggleAIChat()">✖</button>
        </div>
        <div class="ai-chat-messages" id="chatMessages"></div>
        <div class="ai-chat-input">
            <input type="text" id="chatInput" placeholder="Nhập câu hỏi về sản phẩm..." />
            <button onclick="sendMessage()">Gửi</button>
        </div>
    </div>

    <script src="../chatbot/assets/chatbot.js"></script>
</body>
</html>
