$(function () {
    // Добавление в корзину через AJAX
    $('.addtocart').on('submit', function () {
        let form = $(this);
        $.ajax({
            url: form.attr('action'),
            data: form.serialize(),
            type: 'post',
            success: function (result) {
                if (result.success) {
                    $('.mini-cart-qty').text(result.cart_qty);
                }
            },
            error: function (msg) {
                alert('Ошибка');
                console.log(msg.responseJSON);
                form[0].reset();
            }
        });
        return false;
    });

    // Удаление позиции из корзины (делегирование: и в модалке, и на странице заказа)
    $(document).on('click', '.del-item', function () {
        $.ajax({
            url: $(this).data('action'),
            type: 'get',
            success: function (result) {
                if (document.location.pathname === '/cart/checkout') {
                    location = '/cart/checkout';
                } else {
                    showCart(result);
                }
            },
            error: function () {
                alert('Ошибка');
            }
        });
    });

    $(document).on('click', '.clear-cart', function () {
        clearCart($(this).data('action'));
    });
});

function showCart(cart) {
    $('#cart-modal .modal-body').html(cart);
    $('#cart-modal').modal();
    let cartQty = $('#modal-cart-qty').text() ? $('#modal-cart-qty').text() : 0;
    $('.mini-cart-qty').text(cartQty);
}

function getCart(action) {
    $.ajax({
        url: action,
        type: 'get',
        success: function (result) {
            showCart(result);
        },
        error: function () {
            alert('Ошибка');
        }
    });
}

function clearCart(action) {
    $.ajax({
        url: action,
        type: 'get',
        success: function (result) {
            if (document.location.pathname === '/cart/checkout') {
                location = '/cart/checkout';
            } else {
                showCart(result);
            }
        },
        error: function () {
            alert('Ошибка');
        }
    });
}
