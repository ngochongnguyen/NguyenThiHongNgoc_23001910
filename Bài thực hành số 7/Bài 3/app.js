const { createApp } = Vue;

const app = createApp({
    data() {
        return {
            cart: [
                {
                    id: 1,
                    ten: "Bút bi",
                    donGia: 5000,
                    soLuong: 2
                },
                {
                    id: 2,
                    ten: "Vở học sinh",
                    donGia: 12000,
                    soLuong: 3
                }
            ]
        };
    },

    computed: {
        tongSoLuong() {
            return this.cart.reduce(
                (total, item) => total + item.soLuong,
                0
            );
        },

        tongTien() {
            return this.cart.reduce(
                (total, item) => total + item.donGia * item.soLuong,
                0
            );
        }
    },

    methods: {
        formatCurrency(value) {
            return new Intl.NumberFormat("vi-VN", {
                style: "currency",
                currency: "VND"
            }).format(value);
        },

        doiSoLuong(id, soLuongMoi) {
            if (
                !Number.isInteger(soLuongMoi) ||
                soLuongMoi < 1 ||
                soLuongMoi > 99
            ) {
                alert("Số lượng phải là số nguyên từ 1 đến 99!");
                return;
            }

            const product = this.cart.find(item => item.id === id);

            if (product) {
                product.soLuong = soLuongMoi;
            }
        },

        xoaSanPham(id) {
            this.cart = this.cart.filter(item => item.id !== id);
        }
    }
});

app.component("dong-gio-hang", DongGioHang);

app.mount("#app");