function addToCart(id, name, price) {
    let product = {
        id: id,
        name: name,
        price: price,
        quantity: 1
    };

    let cart = JSON.parse(localStorage.getItem('ami_cart')) || [];
    
    // Check if product already exists
    let existingProduct = cart.find(item => item.id === id);
    
    if (existingProduct) {
        existingProduct.quantity += 1;
    } else {
        cart.push(product);
    }

    localStorage.setItem('ami_cart', JSON.stringify(cart));
    alert(name + " added to cart! ✨");
}