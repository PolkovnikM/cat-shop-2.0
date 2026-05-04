let cart = [];
let currentUserId = null;

const products = [
    {
        id: 1,
        name: "Корм Hill's Science Plan",
        category: "food",
        price: 2500,
        description: "Сухой корм для взрослых кошек, 1.5 кг",
        image: "images/cat-food.jpg"
    },
    {
        id: 2,
        name: "Игрушка-удочка с перьями",
        category: "toys",
        price: 450,
        description: "Развивающая игрушка для активных кошек",
        image: "images/cat-toy.jpg"
    },
    {
        id: 3,
        name: "Когтеточка-домик",
        category: "accessories",
        price: 3200,
        description: "Компактная когтеточка с домиком",
        image: "images/scratching-post.jpg"
    },
    {
        id: 4,
        name: "Наполнитель Ever Clean",
        category: "care",
        price: 1800,
        description: "Комкующийся наполнитель, 10 кг",
        image: "images/litter.jpg"
    },
    {
        id: 5,
        name: "Витамины для шерсти VEDA",
        category: "care",
        price: 890,
        description: "Комплекс для здоровой шерсти",
        image: "images/vitamins.jpg"
    },
    {
        id: 6,
        name: "Лежанка-подушка",
        category: "accessories",
        price: 1500,
        description: "Мягкая лежанка для сна",
        image: "images/bed.jpg"
    },
    {
        id: 7,
        name: "Влажный корм Royal Canin",
        category: "food",
        price: 80,
        description: "Паштет для кошек, 85 г",
        image: "images/wet-food.jpg"
    },
    {
        id: 8,
        name: "Лазерная указка",
        category: "toys",
        price: 350,
        description: "Игрушка для активных игр",
        image: "images/laser.jpg"
    }
];

// ========== РАБОТА С СЕРВЕРОМ ==========

async function getCurrentUserId() {
    try {
        const response = await fetch('/api/get-user-id.php');
        const data = await response.json();
        return data.user_id;
    } catch (error) {
        console.error('Ошибка получения user_id:', error);
        return null;
    }
}

async function checkUserChange() {
    const newUserId = await getCurrentUserId();
    
    if (newUserId !== currentUserId) {
        console.log('Пользователь сменился:', currentUserId, '→', newUserId);
        currentUserId = newUserId;
        
        if (currentUserId) {
            await loadCartFromServer();
        } else {
            cart = [];
            updateCart();
        }
    }
}

async function loadCartFromServer() {
    if (!currentUserId) {
        cart = [];
        updateCart();
        return;
    }
    
    try {
        const response = await fetch('/api/cart.php', {
            headers: { 'X-User-Id': currentUserId }
        });
        const data = await response.json();
        if (data.status === 'success') {
            cart = data.data;
            updateCart();
        }
    } catch (error) {
        console.error('Ошибка загрузки корзины:', error);
    }
}

async function saveCartToServer() {
    if (!currentUserId) return;
    
    try {
        await fetch('/api/cart.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-User-Id': currentUserId
            },
            body: JSON.stringify({ cart: cart })
        });
    } catch (error) {
        console.error('Ошибка сохранения корзины:', error);
    }
}

async function addToServer(product) {
    if (!currentUserId) return;
    
    try {
        await fetch('/api/cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-User-Id': currentUserId
            },
            body: JSON.stringify({ product: product })
        });
    } catch (error) {
        console.error('Ошибка добавления на сервер:', error);
    }
}

async function clearCartOnServer() {
    if (!currentUserId) return;
    
    try {
        await fetch('/api/cart.php', {
            method: 'DELETE',
            headers: { 'X-User-Id': currentUserId }
        });
    } catch (error) {
        console.error('Ошибка очистки корзины на сервере:', error);
    }
}

// ========== ОТРИСОВКА КАТАЛОГА ==========

function renderCatalog() {
    let container = document.querySelector(".catalog-grid");
    if (!container) return;
    
    container.innerHTML = "";
    
    for (let i = 0; i < products.length; i++) {
        let p = products[i];
        let card = `
            <div class="product-card" data-category="${p.category}" data-id="${p.id}">
                <img src="${p.image}" alt="${p.name}" width="150" height="120">
                <h3>${p.name}</h3>
                <p>${p.description}</p>
                <p class="price">${p.price} ₽</p>
                <button class="add-btn" data-id="${p.id}">Добавить в корзину</button>
            </div>
        `;
        container.innerHTML += card;
    }
    
    let buttons = document.querySelectorAll(".add-btn");
    for (let i = 0; i < buttons.length; i++) {
        buttons[i].addEventListener("click", async function(e) {
            let id = parseInt(this.getAttribute("data-id"));
            await addToCart(id);
        });
    }
}

// ========== РАБОТА С КОРЗИНОЙ ==========

async function addToCart(productId, productName, productPrice, productImage) {
    if (productName && productPrice && productImage) {
        let found = false;
        for (let i = 0; i < cart.length; i++) {
            if (cart[i].id === productId) {
                cart[i].quantity++;
                found = true;
                break;
            }
        }
        
        if (!found) {
            cart.push({
                id: productId,
                name: productName,
                price: productPrice,
                image: productImage,
                quantity: 1
            });
        }
        
        updateCart();
        await addToServer({ id: productId, name: productName, price: productPrice, image: productImage });
        return;
    }
    
    let product = null;
    for (let i = 0; i < products.length; i++) {
        if (products[i].id === productId) {
            product = products[i];
            break;
        }
    }
    
    if (!product) return;
    
    let found = false;
    for (let i = 0; i < cart.length; i++) {
        if (cart[i].id === productId) {
            cart[i].quantity++;
            found = true;
            break;
        }
    }
    
    if (!found) {
        cart.push({
            id: product.id,
            name: product.name,
            price: product.price,
            image: product.image,
            quantity: 1
        });
    }
    
    updateCart();
    await addToServer(product);
}

function updateCart() {
    let cartContainer = document.querySelector(".cart-items");
    let totalElement = document.querySelector(".cart-total");
    let cartCount = document.querySelector(".cart-count");
    
    if (!cartContainer) return;
    
    cartContainer.innerHTML = "";
    
    if (cart.length === 0) {
        cartContainer.innerHTML = "<p>Корзина пуста</p>";
        if (totalElement) totalElement.innerHTML = "Итого: 0 ₽";
        if (cartCount) cartCount.innerHTML = "0";
        return;
    }
    
    let total = 0;
    let totalItems = 0;
    
    for (let i = 0; i < cart.length; i++) {
        let item = cart[i];
        let itemTotal = item.price * item.quantity;
        total += itemTotal;
        totalItems += item.quantity;
        
        let cartItem = `
            <div class="cart-item">
                <span>${item.name}</span>
                <span>${item.price} ₽ x ${item.quantity} = ${itemTotal} ₽</span>
                <button class="remove-btn" data-id="${item.id}">Удалить</button>
            </div>
        `;
        cartContainer.innerHTML += cartItem;
    }
    
    let removeButtons = document.querySelectorAll(".remove-btn");
    for (let i = 0; i < removeButtons.length; i++) {
        removeButtons[i].addEventListener("click", async function(e) {
            let id = parseInt(this.getAttribute("data-id"));
            await removeFromCart(id);
        });
    }
    
    if (totalElement) totalElement.innerHTML = "Итого: " + total + " ₽";
    if (cartCount) cartCount.innerHTML = totalItems;
}

const removeFromCart = async (productId) => {
    const itemIndex = cart.findIndex(item => item.id === productId);
    
    if (itemIndex !== -1) {
        if (cart[itemIndex].quantity > 1) {
            cart[itemIndex].quantity--;
        } else {
            cart.splice(itemIndex, 1);
        }
    }
    
    updateCart();
    await saveCartToServer();
};

const clearCart = async () => {
    if (cart.length === 0) {
        alert("Корзина пуста!");
        return;
    }
    cart = [];
    updateCart();
    await clearCartOnServer();
    alert("Корзина очищена");
};

const checkout = async () => {
    if (cart.length === 0) {
        alert("Корзина пуста!");
        return;
    }
    
    let total = 0;
    let kittensCount = 0;
    for (let i = 0; i < cart.length; i++) {
        total += cart[i].price * cart[i].quantity;
        if (cart[i].id >= 101 && cart[i].id <= 105) {
            kittensCount += cart[i].quantity;
        }
    }
    
    let message = "Покупка прошла успешно! Сумма: " + total + " ₽";
    if (kittensCount > 0) {
        message += "\nКотят: " + kittensCount + " шт.";
    }
    alert(message);
    cart = [];
    updateCart();
    await clearCartOnServer();
};

// ========== ФИЛЬТР ==========

function filterProducts(category) {
    let cards = document.querySelectorAll(".product-card");
    
    for (let i = 0; i < cards.length; i++) {
        let card = cards[i];
        let cat = card.getAttribute("data-category");
        
        if (category === "all" || cat === category) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    }
}

// ========== ЗАПУСК ==========

document.addEventListener("DOMContentLoaded", async function() {
    currentUserId = await getCurrentUserId();
    await loadCartFromServer();
    
    renderCatalog();
    updateCart();
    
    // Проверка смены пользователя каждую секунду
    setInterval(checkUserChange, 1000);
    
    let kittenBtns = document.querySelectorAll(".add-kitten");
    for (let i = 0; i < kittenBtns.length; i++) {
        kittenBtns[i].addEventListener("click", async function() {
            let id = parseInt(this.getAttribute("data-id"));
            let name = this.getAttribute("data-name");
            let price = parseInt(this.getAttribute("data-price"));
            let image = this.getAttribute("data-image");
            await addToCart(id, name, price, image);
            
            let originalText = this.textContent;
            this.textContent = "Добавлено";
            setTimeout(() => {
                this.textContent = originalText;
            }, 1000);
        });
    }
    
    let filterBtns = document.querySelectorAll(".filter-btn");
    for (let i = 0; i < filterBtns.length; i++) {
        filterBtns[i].addEventListener("click", function() {
            let category = this.getAttribute("data-category");
            filterProducts(category);
            
            for (let j = 0; j < filterBtns.length; j++) {
                filterBtns[j].classList.remove("active");
            }
            this.classList.add("active");
        });
    }
    
    let clearBtn = document.querySelector(".clear-cart-btn");
    if (clearBtn) {
        clearBtn.addEventListener("click", clearCart);
    }
    
    let checkoutBtn = document.querySelector(".checkout-btn");
    if (checkoutBtn) {
        checkoutBtn.addEventListener("click", checkout);
    }
});