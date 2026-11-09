const { createApp } = Vue;
createApp({
    data() {
        return {
            pageStatus: "Đang tải...",
            keyword: "",
            searchNotice: "",
            selectedCategory: "",
            sortOrder: "",
            formError: "",

            categories: [
                "Điện tử",
                "Thời trang",
                "Gia dụng"
            ],

            // Danh sách sản phẩm ban đầu
            products: [
                {
                    id: 1,
                    name: "Laptop Dell",
                    price: 15000000,
                    category: "Điện tử",
                    stock: 5
                },
                {
                    id: 2,
                    name: "Điện thoại Samsung",
                    price: 10000000,
                    category: "Điện tử",
                    stock: 8
                },
                {
                    id: 3,
                    name: "Áo thun",
                    price: 200000,
                    category: "Thời trang",
                    stock: 20
                },
                {
                    id: 4,
                    name: "Quần jean",
                    price: 450000,
                    category: "Thời trang",
                    stock: 0
                },
                {
                    id: 5,
                    name: "Nồi cơm điện",
                    price: 800000,
                    category: "Gia dụng",
                    stock: 10
                },
                {
                    id: 6,
                    name: "Máy xay sinh tố",
                    price: 600000,
                    category: "Gia dụng",
                    stock: 0
                }
            ],

            // Dữ liệu sản phẩm mới
            newProduct: {
                name: "",
                price: "",
                category: "Điện tử",
                stock: ""
            }
        };
    },

    // Computed: lọc và sắp xếp sản phẩm
    computed: {
        filteredProducts() {
            let result = this.products.filter(product => {

                // Tìm kiếm theo tên, không phân biệt hoa thường
                const matchName = product.name
                    .toLowerCase()
                    .includes(this.keyword.trim().toLowerCase());

                // Lọc theo danh mục
                const matchCategory =
                    this.selectedCategory === "" ||
                    product.category === this.selectedCategory;

                return matchName && matchCategory;
            });

            // Sắp xếp trên mảng mới, không thay đổi mảng gốc
            if (this.sortOrder === "asc") {
                result = [...result].sort(
                    (a, b) => a.price - b.price
                );
            } else if (this.sortOrder === "desc") {
                result = [...result].sort(
                    (a, b) => b.price - a.price
                );
            }

            return result;
        },

        // Số sản phẩm đang hiển thị
        displayedCount() {
            return this.filteredProducts.length;
        },

        // Tổng giá trị tồn kho của sản phẩm đang hiển thị
        totalInventoryValue() {
            return this.filteredProducts.reduce(
                (total, product) => {
                    return total + product.price * product.stock;
                },
                0
            );
        }
    },

    // Watch: theo dõi từ khóa tìm kiếm
    watch: {
        keyword(newValue) {
            const value = newValue.trim();

            if (value.length === 1) {
                this.searchNotice =
                    "Bạn mới nhập 1 ký tự. Hãy nhập thêm để tìm kiếm chính xác hơn!";
            } else {
                this.searchNotice = "";
            }
        }
    },

    methods: {
        // Định dạng tiền Việt Nam
        formatCurrency(value) {
            return new Intl.NumberFormat("vi-VN", {
                style: "currency",
                currency: "VND"
            }).format(value);
        },

        // Thêm sản phẩm mới
        addProduct() {
            const name = this.newProduct.name.trim();
            const price = Number(this.newProduct.price);
            const stock = Number(this.newProduct.stock);

            // Kiểm tra tên không được để trống
            if (name === "") {
                this.formError = "Tên sản phẩm không được để trống!";
                return;
            }

            // Kiểm tra giá lớn hơn 0
            if (
                this.newProduct.price === "" ||
                !Number.isFinite(price) ||
                price <= 0
            ) {
                this.formError = "Giá sản phẩm phải lớn hơn 0!";
                return;
            }

            // Kiểm tra tồn kho là số nguyên không âm
            if (
                this.newProduct.stock === "" ||
                !Number.isInteger(stock) ||
                stock < 0
            ) {
                this.formError =
                    "Số lượng tồn phải là số nguyên không âm!";
                return;
            }

            // Tạo sản phẩm mới
            const newId = Math.max(
                0,
                ...this.products.map(product => product.id)
            ) + 1;

            this.products.push({
                id: newId,
                name: name,
                price: price,
                category: this.newProduct.category,
                stock: stock
            });

            // Xóa thông báo lỗi và làm mới biểu mẫu
            this.formError = "";

            this.newProduct = {
                name: "",
                price: "",
                category: "Điện tử",
                stock: ""
            };

            alert("Thêm sản phẩm thành công!");
        },

        // Xóa sản phẩm sau khi xác nhận
        deleteProduct(id) {
            const product = this.products.find(
                item => item.id === id
            );

            if (!product) return;

            const confirmed = window.confirm(
                `Bạn có chắc chắn muốn xóa sản phẩm "${product.name}" không?`
            );

            if (confirmed) {
                this.products = this.products.filter(
                    item => item.id !== id
                );
            }
        }
    },

    // Mounted: chạy khi ứng dụng được gắn vào DOM
    mounted() {
        this.pageStatus = "Sẵn sàng";
    }

}).mount("#app");
