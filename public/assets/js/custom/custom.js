////////////////////////////////////////////////////////////////////////////////////////////////////

/** Unit Start*/
//edit modal
$('.edit-btn').each(function () {
    let container = $(this);
    let id = container.data('id');

    $('#edit_' + id).on('click', function () {
        // alert($('#edit_'+service).data('holder-name'));
        $('#unit_edit_name').val($('#edit_' + id).data('name'));
        $('#unit_edit_short_name').val($('#edit_' + id).data('short_name'));

        let editactionroute = $(this).data('url');
        $('#editForm').attr('action', editactionroute + '/' + id);
    });
});
/** Unit End*/

/** Category Start */
//edit modal
$('.edit-btn').each(function () {
    let container = $(this);
    let id = container.data('id');

    $('#edit_' + id).on('click', function () {
        $('#category_edit_name').val($('#edit_' + id).data('name'));

        let editactionroute = $(this).data('url');
        $('#editForm').attr('action', editactionroute + '/' + id);
    });
});
/** Category End */

/** Brand Start */
//edit modal
$('.edit-btn').each(function () {
    let container = $(this);
    let id = container.data('id');

    $('#edit_' + id).on('click', function () {
        $('#brand_edit_name').val($('#edit_' + id).data('name'));

        let editactionroute = $(this).data('url');
        $('#editForm').attr('action', editactionroute + '/' + id);
    });
});
/** Brand End */

/** Warranty Start */
//edit modal
$('.edit-btn').each(function () {
    let container = $(this);
    let id = container.data('id');

    $('#edit_' + id).on('click', function () {
        $('#warranty_edit_duration').val($('#edit_' + id).data('duration'));

        let editactionroute = $(this).data('url');
        $('#editForm').attr('action', editactionroute + '/' + id);
    });
});
/** Warranty End */

/** Model Start */
//edit modal
$('.edit-btn').each(function () {
    let container = $(this);
    let id = container.data('id');

    $('#edit_' + id).on('click', function () {
        $('#model_edit_brand_id').val($('#edit_' + id).data('brand_id'));
        $('#model_edit_name').val($('#edit_' + id).data('name'));

        let editactionroute = $(this).data('url');
        $('#editForm').attr('action', editactionroute + '/' + id);
    });
});
/** Model End */

/** Warehouse Start */
//edit modal
$('.edit-btn').each(function () {
    let container = $(this);
    let id = container.data('id');

    $('#edit_' + id).on('click', function () {
        $('#warehouse_edit_name').val($('#edit_' + id).data('name'));
        $('#warehouse_edit_phone').val($('#edit_' + id).data('phone'));
        $('#warehouse_edit_email').val($('#edit_' + id).data('email'));
        $('#warehouse_edit_address').val($('#edit_' + id).data('address'));
        $('#warehouse_edit_city').val($('#edit_' + id).data('city'));
        $('#warehouse_edit_zip_code').val($('#edit_' + id).data('zip_code'));

        let editactionroute = $(this).data('url');
        $('#editForm').attr('action', editactionroute + '/' + id);
    });
});
/** Warehouse End */

/** Branch Start */
//edit modal
$('.edit-btn').each(function () {
    let container = $(this);
    let id = container.data('id');

    $('#edit_' + id).on('click', function () {
        $('#branch_edit_name').val($('#edit_' + id).data('name'));
        $('#branch_edit_contact_name').val($('#edit_' + id).data('contact_name'));
        $('#branch_edit_phone').val($('#edit_' + id).data('phone'));
        $('#branch_edit_address').val($('#edit_' + id).data('address'));
        $('#branch_edit_note').val($('#edit_' + id).data('note'));

        let editactionroute = $(this).data('url');
        $('#editForm').attr('action', editactionroute + '/' + id);
    });
});
/** Branch End */

/** Branch Start */
//edit modal
$('.edit-btn').each(function () {
    let container = $(this);
    let id = container.data('id');

    $('#edit_' + id).on('click', function () {
        $('#designation_edit_name').val($('#edit_' + id).data('name'));
        $('#designation_edit_description').val($('#edit_' + id).data('description'));

        let editactionroute = $(this).data('url');
        $('#editForm').attr('action', editactionroute + '/' + id);
    });
});
/** Branch End */

/** Employee Start */
//edit modal
$('.edit-btn').each(function () {
    let container = $(this);
    let id = container.data('id');

    $('#edit_' + id).on('click', function () {
        $('#employee_edit_first_name').val($('#edit_' + id).data('first_name'));
        $('#employee_edit_last_name').val($('#edit_' + id).data('last_name'));
        $('#employee_edit_phone').val($('#edit_' + id).data('phone'));
        $('#employee_edit_email').val($('#edit_' + id).data('email'));
        $('#employee_edit_address').val($('#edit_' + id).data('address'));
        $('#employee_edit_gender').val($('#edit_' + id).data('gender'));
        $('#employee_edit_employee_type').val($('#edit_' + id).data('employee_type'));
        $('#employee_edit_birth_date').val($('#edit_' + id).data('birth_date'));
        $('#employee_edit_join_date').val($('#edit_' + id).data('join_date'));
        $('#employee_designation_id').val($('#edit_' + id).data('designation_id'));
        $('#employee_edit_salary').val($('#edit_' + id).data('salary'));
        $('#employee_edit_branch_id').val($('#edit_' + id).data('branch_id'));

        let editactionroute = $(this).data('url');
        $('#editForm').attr('action', editactionroute + '/' + id);
    });
});
/** Employee End */

/** Service Start */
//edit modal
$('.edit-btn').each(function () {
    let container = $(this);
    let id = container.data('id');

    $('#edit_' + id).on('click', function () {
        $('#service_edit_name').val($('#edit_' + id).data('name'));
        $('#service_edit_charge').val($('#edit_' + id).data('charge'));
        $('#service_edit_note').val($('#edit_' + id).data('note'));

        let editactionroute = $(this).data('url');
        $('#editForm').attr('action', editactionroute + '/' + id);
    });
});
/** Service End */

/** Party Start */
function addMoreFeature()
{
    let length = parseInt($(".duplicate-feature").length) + 1; // Increment length by 1
    if (length > 3) {
        toastr.error("You can not add more than 3 Reference!");
        return;
    }
     var newFeature = $(".duplicate-feature:last").clone().insertAfter("div.duplicate-feature:last");

    $('.reference:last').text('Reference - ' + length);
    $('.duplicate-feature:last .clear-input').val('');

    $('.duplicate-feature:last .clear-img').val(null); // Clear the file input
    $('.duplicate-feature:last .table-img').attr('src', ''); // Clear the image source
}

function removeFeature(button) {
    $(button).closest('.duplicate-feature').remove();
}
/** Party End */

/** Product Start */
function updateSalePrice() {
    let unitPrice = parseFloat($('.unit_price').val()) || 0;
    let discountType = $('.discount_type').val();
    let discount = parseFloat($('.discount').val()) || 0;

    // Calculate the sales price based on discount type
    let salePrice = 0;
    if (discountType === 'fixed') {
        salePrice = unitPrice - discount;
    } else if (discountType === 'percentage') {
        let discountAmount = unitPrice * (discount / 100);
        salePrice = unitPrice - discountAmount;
    }

    $('#sale_price').val(salePrice.toFixed(2));
}
// updateSalesPrice will call when these fields change
$('.unit_price, .discount_type, .discount, .vat').on('input change', updateSalePrice);

/** Product End */

/** Service Start */
//edit modal
$('.edit-btn').each(function () {
    let container = $(this);
    let id = container.data('id');

    $('#edit_' + id).on('click', function () {
        $('#employee_edit_salary').val($('#edit_' + id).data('salary'));

        let editactionroute = $(this).data('url');
        $('#editForm').attr('action', editactionroute + '/' + id);
    });
});
/** Service End */

/** SMS Start */
//edit modal
$('.edit-btn').each(function () {
    let container = $(this);
    let id = container.data('id');

    $('#edit_' + id).on('click', function () {
        $('#sms_edit_party_id').val($('#edit_' + id).data('party_id'));
        $('#sms_edit_message').val($('#edit_' + id).data('message'));

        let editactionroute = $(this).data('url');
        $('#editForm').attr('action', editactionroute + '/' + id);
    });
});
/** SMS End */
