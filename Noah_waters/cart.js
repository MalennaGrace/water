// Function to add item to cart
function addToCart(productId) {
    const formData = new FormData();
    formData.append('action', 'add');
    formData.append('product_id', productId);
    formData.append('quantity', 1);

    fetch('cart_operations.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadCart();
        } else {
            alert(data.message || 'Error adding item to cart');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding item to cart');
    });
}

// Function to load cart
function loadCart() {
    const formData = new FormData();
    formData.append('action', 'get');

    fetch('cart_operations.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const cartItemsEl = document.getElementById('cart-items');
        const subtotalEl = document.getElementById('subtotal');
        const totalEl = document.getElementById('total');

        if (data.success && data.items.length > 0) {
            let html = '';
            let subtotal = 0;

            data.items.forEach(item => {
                html += `
                    <div class="cart-item" data-cart-id="${item.product_id}">
                        <strong class="item-name">${item.name}</strong>
                        <span>₱${parseFloat(item.price).toFixed(2)}</span>
                        <div class="qty-controls">
                            <button class="qty-btn" onclick="changeQuantity(${item.product_id}, -1)">-</button>
                            <input type="text" value="${item.quantity}" id="qty-${item.product_id}" readonly />
                            <button class="qty-btn" onclick="changeQuantity(${item.product_id}, 1)">+</button>
                        </div>
                        <button class="remove-btn" onclick="removeItem(${item.product_id})">🗑️</button>
                    </div>`;
            });

            data.items.forEach(item => {
                subtotal += parseFloat(item.price) * parseInt(item.quantity);
            });

            cartItemsEl.innerHTML = html;
            subtotalEl.textContent = `₱${subtotal.toFixed(2)}`;
            totalEl.textContent = `₱${subtotal.toFixed(2)}`;
        } else {
            cartItemsEl.innerHTML = "<p>Your cart is empty.</p>";
            subtotalEl.textContent = '₱0.00';
            totalEl.textContent = '₱0.00';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Function to change quantity
function changeQuantity(productId, delta) {
    const qtyInput = document.getElementById('qty-' + productId);
    let currentQty = parseInt(qtyInput.value);
    let newQty = currentQty + delta;
    
    if (newQty < 1) return;
    
    const formData = new FormData();
    formData.append('action', 'update');
    formData.append('product_id', productId);
    formData.append('quantity', newQty);

    fetch('cart_operations.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadCart();
        } else {
            alert(data.message || 'Error updating quantity');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating quantity');
    });
}

// Function to remove item
function removeItem(productId) {
    const formData = new FormData();
    formData.append('action', 'remove');
    formData.append('product_id', productId);

    fetch('cart_operations.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadCart();
        } else {
            alert(data.message || 'Error removing item');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error removing item');
    });
}

// Load cart when page loads
document.addEventListener('DOMContentLoaded', loadCart); 