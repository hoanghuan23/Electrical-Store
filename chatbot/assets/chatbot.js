const keys = process.env.GEMINI_API_KEY || '';

if (!keys) {
    console.error('GEMINI_API_KEY không được cấu hình trong file .env');
}

function toggleAIChat() {
    try {
        const chatBox = document.getElementById("aiChatContainer");
        if (!chatBox) {
            console.error("Không tìm thấy phần tử aiChatContainer");
            return;
        }
        chatBox.style.display = (chatBox.style.display === "none") ? "block" : "none";
        
        if (chatBox.style.display === "block") {
            document.getElementById("chatInput").focus();
        }
    } catch (error) {
        console.error("Lỗi khi toggle chat:", error);
    }
}

// Thêm event listener cho phím Enter
document.addEventListener('DOMContentLoaded', function() {
    const inputField = document.getElementById("chatInput");
    inputField.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            sendMessage();
        }
    });
});

async function sendMessage() {
    const inputField = document.getElementById("chatInput");
    const userMessage = inputField.value.trim();
    if (!userMessage) return;

    displayMessage(userMessage, "user");
    inputField.value = "";

    try {
        // First try to search for products
        const searchResponse = await fetch("functions/search_product.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                query: userMessage
            })
        });

        if (!searchResponse.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await searchResponse.json();
        console.log("Kết quả tìm kiếm:", data);

        if (data.error) {
            throw new Error(data.error);
        }

        if (data.products && data.products.length > 0) {
            displayProducts(data.products);
        } else {
            // If no products found, try AI response
            await handleAIResponse(userMessage);
        }
    } catch (error) {
        console.error("Lỗi tìm kiếm:", error);
        await handleAIResponse(userMessage);
    }
}

async function handleAIResponse(userMessage) {
    try {
        const aiPrompt = `Tôi muốn hỏi về sản phẩm: ${userMessage}.`;

        const response = await fetch(
            `https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-pro-latest:generateContent?key=${keys}`,
            {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    contents: [{
                        parts: [{
                            text: aiPrompt
                        }]
                    }],
                    generation_config: {
                        temperature: 0.7,
                        max_output_tokens: 500
                    }
                })
            }
        );

        const data = await response.json();
        
        if (data.error) {
            displayMessage("Xin lỗi, tôi không thể xử lý yêu cầu của bạn lúc này. Vui lòng thử lại sau.", "ai");
            return;
        }

        const aiResponse = data?.candidates?.[0]?.content?.parts?.[0]?.text ||
            "Xin lỗi, tôi không thể tìm thấy thông tin phù hợp. Bạn có thể thử tìm kiếm với từ khóa khác hoặc xem các sản phẩm trên website của chúng tôi.";
        
        displayMessage(aiResponse, "ai");
    } catch (error) {
        console.error("Lỗi gọi AI:", error);
        displayMessage("Xin lỗi, có lỗi xảy ra. Vui lòng thử lại sau.", "ai");
    }
}

function displayProducts(products) {
    let productMessage = "AI: Đây là những sản phẩm phù hợp với yêu cầu của bạn:<br><div class='product-grid'>";
    
    products.forEach(product => {
        const formattedPrice = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(product.product_price);

        productMessage += `
            <div class="product-card">
                <img src="assets/images/products/${product.img}" alt="${product.product_name}" class="product-image">
                <div class="product-info">
                    <h3>${product.product_name}</h3>
                    <p class="product-color">${product.product_color}</p>
                    <p class="product-price">${formattedPrice}</p>
                    <a href="?view=product-detail&id=${product.product_id}" class="view-detail">Xem chi tiết</a>
                </div>
            </div>`;
    });
    
    productMessage += "</div>";
    displayMessage(productMessage, "ai");
}

function displayMessage(message, sender) {
    const chatMessages = document.getElementById("chatMessages");
    const messageElement = document.createElement("div");
    messageElement.className = sender === "user" ? "user-message" : "ai-message";

    let formattedMessage = message
        .replace(/\*\*(.*?)\*\*/g, "<b>$1</b>")
        .replace(/\*(.*?)\*/g, "<i>$1</i>")
        .replace(/\n\* (.*?)/g, "<li>$1</li>");

    if (formattedMessage.includes("<li>")) {
        formattedMessage = "<ul>" + formattedMessage + "</ul>";
    }

    messageElement.innerHTML = formattedMessage;
    chatMessages.appendChild(messageElement);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}