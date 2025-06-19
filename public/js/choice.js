document.addEventListener('DOMContentLoaded', function() {
    // Initialize Choices.js for bank selection
    const bankSelect = document.getElementById('validationbank_name');

    if (bankSelect) {
        const choices = new Choices(bankSelect, {
            searchEnabled: true,
            searchPlaceholderValue: 'Tìm kiếm ngân hàng...',
            noResultsText: 'Không tìm thấy ngân hàng',
            noChoicesText: 'Không có lựa chọn nào',
            itemSelectText: 'Nhấn để chọn',
            removeItemButton: false,
            shouldSort: false,
            placeholder: true,
            placeholderValue: 'Chọn ngân hàng'
        });
    }
});
