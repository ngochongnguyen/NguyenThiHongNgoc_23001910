const DongGioHang = {
    props: {
        id: {
            type: Number,
            required: true
        },
        ten: {
            type: String,
            required: true
        },
        donGia: {
            type: Number,
            required: true
        },
        soLuong: {
            type: Number,
            required: true
        }
    },

    emits: ["doi-so-luong", "yeu-cau-xoa"],

    methods: {
        formatCurrency(value) {
            return new Intl.NumberFormat("vi-VN", {
                style: "currency",
                currency: "VND"
            }).format(value);
        },

        tangSoLuong() {
            if (this.soLuong < 99) {
                this.$emit("doi-so-luong", this.id, this.soLuong + 1);
            }
        },

        giamSoLuong() {
            if (this.soLuong > 1) {
                this.$emit("doi-so-luong", this.id, this.soLuong - 1);
            }
        },

        xoaSanPham() {
            this.$emit("yeu-cau-xoa", this.id);
        }
    },

    template: `
        <div class="cart-item">
            <div class="product-info">
                <h3>{{ ten }}</h3>
                <p>Đơn giá: {{ formatCurrency(donGia) }}</p>
                <p class="subtotal">
                    Thành tiền: {{ formatCurrency(donGia * soLuong) }}
                </p>
            </div>

            <div class="quantity-control">
                <button @click="giamSoLuong" :disabled="soLuong <= 1">-</button>
                <span>{{ soLuong }}</span>
                <button @click="tangSoLuong" :disabled="soLuong >= 99">+</button>
            </div>

            <button class="delete-btn" @click="xoaSanPham">Xóa</button>
        </div>
    `
};