$(document).ready(function () {

    $('.add-basket').click(function () {
        var product_id = $(this).data('product-id');
        var quantity = $(this).data('quantity');
        var product_name = $(this).data('product-name');
        swal({
                title: "Emin misiniz ?",
                text: product_name + " sepete ekleniyor",
                type: "warning",
                cancelButtonText: "İPTAL ET",
                showCancelButton: true,
                confirmButtonColor: "orange",
                confirmButtonText: "SEPETE EKLE",
                closeOnConfirm: false
            },
            function () {
                $.ajax({
                    url: '/api/shopping-cart/add-to-cart',
                    type: "POST",
                    data: {'product_id': product_id, 'quantity': quantity, 'product_name': product_name},
                    success: function (response) {
                        var result = $.parseJSON(JSON.stringify(response));
                        if (result.status == 'success') {
                            $(".load-shopping-cart").load("/api/shopping-cart/load-cart", function () {
                            });
                            swal({
                                title: result.message,
                                text: result.product_name,
                                confirmButtonColor: "#66BB6A",
                                type: result.status,
                                showCancelButton: true,
                                cancelButtonText: "ALIŞVERİŞE DEVAM ET",
                                cancelButtonColor: "#64c41b",
                                confirmButtonText: "SEPETE GİT",
                            }, function () {
                                window.location.href = '/sepetim';
                            });
                        }
                        else if (result.status == 'error') {
                            swal({
                                title: result.message,
                                text: result.product_name,
                                type: result.status,
                                confirmButtonText: "KAPAT",
                            }, function () {

                            });
                        }
                    },
                    error: function () {
                        swal("Hata oluştu!")
                    }
                });
            });
    });


    $('.remove-item').click(function () {
        var cart_id = $(this).data('cart-id');
        var product_name = $(this).data('product-name');
        swal({
                title: "Emin misiniz ?",
                text: product_name + " sepetinizden kaldırılıyor.",
                type: "warning",
                cancelButtonText: "İPTAL ET",
                showCancelButton: true,
                confirmButtonColor: "orange",
                confirmButtonText: "KALDIR",
                closeOnConfirm: false
            },
            function () {
                $.ajax({
                    url: '/api/shopping-cart/remove-cart-item',
                    type: "POST",
                    data: {'cart_id': cart_id},
                    success: function (response) {
                        var result = $.parseJSON(JSON.stringify(response));
                        if (result.status == 'success') {
                            swal("İşlem başarılı", result.message, result.status);
                            $(".load-shopping-cart").load("/api/shopping-cart/load-cart", function () {
                            });
                        } else if (result.status == 'error') {
                            swal("Hata", result.message, result.status);
                        }
                    },
                    error: function () {
                        swal("Hata oluştu!")
                    }
                });
            });
    });
});