class ShopItem {
  constructor(name, price) {
    this.name = name;
    this.price = price;
    this.uuid = this.uuidv4();
  }

  uuidv4() { // crypto doesn't work without https, but a low-budget version will do just fine for this.
    return "10000000-1000-4000-8000-100000000000".replace(/[018]/g, c =>
      (+c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> +c / 4).toString(16)
    );
  }
}

class ShopListing {
  constructor(name, price) {
    this.name = name;
    this.price = price;
  }
}

const cart_button_map = [new ShopListing("Aloe Plant", 19.69), new ShopListing("Apple Tree", 100.00), new ShopListing("Birch Tree", 69.00), new ShopListing("Maple Tree", 90.00), new ShopListing("String of Pearls", 25.00), new ShopListing("Spider Plant", 15.00), new ShopListing("Bird House", 12.00), new ShopListing("Potting Soil", 20.00), new ShopListing("Watering Can", 4.20)];
let cart_items = [];
let total = 0.0;
const cart_total = document.getElementById("total");

function calculateTotal() {
  total = 0.0;
  for (let cart_item of cart_items) {
    total += cart_item.price;
  }

  cart_total.innerHTML = "Total: " + total.toFixed(2);
}

const add_to_cart_buttons = document.querySelectorAll(".add_to_cart_button");
for (let i = 0; i < add_to_cart_buttons.length; i++) {
  add_to_cart_buttons[i].addEventListener("click", () => {
    let item = new ShopItem(cart_button_map[i].name, cart_button_map[i].price);
    cart_items.push(item);
    sessionStorage.setItem("cart_items", JSON.stringify(cart_items));
    alert("Added \"" + item.name + "\" to the cart.");
  })
}

function createElements() {
  $("#cart_view_items").empty();
  cart_items.forEach((item) => {
    let cart_item = new CartItem(item);
    cart_item.createElements();
  })

  if (cart_items.length === 0) {
    $("#cart_view_items").append('<li id="empty_cart"><h2>Your cart is empty.</h2></li>');
  }

  calculateTotal();
}

class CartItem {
  constructor(shop_item) {
    this.shop_item = shop_item;
    this.uuid = shop_item.uuid;
  }

  createElements() {
    $('#cart_view_items').append('<li class="cart_item" id='+this.uuid+'><div class="name_price_bundle"><h2>'+this.shop_item.name+'</h2><h3>$'+this.shop_item.price.toFixed(2)+'</h3></div><button class="remove_button" id='+this.uuid+'_button'+'>Remove</button></li>');
    document.getElementById(this.uuid+'_button').addEventListener('click', () => {
      $('#'+this.uuid).remove();
      for (let i = 0; i < cart_items.length; i++) {
        if (cart_items[i].uuid === this.uuid) {
          cart_items.splice(i, 1);
          break;
        }
      }

      if (cart_items.length === 0) {
        $("#cart_view_items").append('<li id="empty_cart"><h2>Your cart is empty.</h2></li>');
      }

      calculateTotal();
      sessionStorage.setItem("cart_items", JSON.stringify(cart_items));
    })
    $("#empty_cart").remove();
  }
}

const cart_button = document.querySelector(".cart_button");
const cart_view = document.querySelector(".cart_view");

function recreateElements() {
  $("cart_view_items").empty();
  cart_items.forEach(item => {
    item.createElements();
  })
}

function toggleCart() {
  cart_view.classList.toggle("active");
  cart_items = JSON.parse(sessionStorage.getItem("cart_items")) || [];
  console.log(cart_items);
  createElements();
  console.log(cart_items);
}

cart_button.addEventListener("click", () => {
  toggleCart();
});

const return_to_shop = document.getElementById("return_to_shop");
return_to_shop.addEventListener("click", (e) => {
  toggleCart();
});

function clearCart() {
  clearCartOnly();
  alert("Cart has been cleared.");
}

function clearCartOnly() {
  cart_items = [];
  sessionStorage.setItem("cart_items", JSON.stringify(cart_items));
  $("#cart_view_items").empty();
  $("#cart_view_items").append('<li id="empty_cart"><h2>Your cart is empty.</h2></li>');
  calculateTotal();
}

const clear_cart = document.getElementById("clear_cart");
clear_cart.addEventListener("click", () => {
  clearCart();
})

const process_order = document.getElementById("process_order");
process_order.addEventListener("click", () => {
  if (cart_items.length === 0) {
    alert("Cannot complete your order because your cart is empty.");
    return;
  }
  clearCartOnly();
  alert("Thank you for your order!");
})


