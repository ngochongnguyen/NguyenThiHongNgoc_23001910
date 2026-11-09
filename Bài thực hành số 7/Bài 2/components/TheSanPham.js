
const TheSanPham = {
    props: {
        ten: {
            type: String,
            required: true
        },
        gia: {
            type: Number,
            required: true
        },
        anh: {
            type: String,
            default: "https://placehold.co/300x200?text=Product"
        },
        moTa: {
            type: String,
            required: true
        },
        soLuongTon: {
            type: Number,
            required: true
        }
    },

    emits: ["mua-san-pham"],

    data() {
        return {
            hienMoTa: false
        };
    },

    methods: {
        formatCurrency(value) {
            return new Intl.NumberFormat("vi-VN", {
                style: "currency",
                currency: "VND"
            }).format(value);
        },

        toggleMoTa() {
            this.hienMoTa = !this.hienMoTa;
        }
    },

    template: `
        <div class="product-card">
            <img :src="anh" :alt="ten" class="product-image">

            <div class="product-content">
                <h3>{{ ten }}</h3>

                <p class="price">
                    {{ formatCurrency(gia) }}
                </p>

                <p class="stock">
                    Số lượng tồn: {{ soLuongTon }}
                </p>

                <span v-if="soLuongTon > 0" class="in-stock">
                    Còn hàng
                </span>

                <span v-else class="out-stock">
                    Hết hàng
                </span>

                <div v-if="hienMoTa" class="description">
                    {{ moTa }}
                </div>

                <button
                    class="btn-description"
                    @click="toggleMoTa"
                >
                    {{ hienMoTa ? 'Ẩn mô tả' : 'Xem mô tả' }}
                </button>

                <button
                    class="btn-buy"
                    :disabled="soLuongTon === 0"
                    @click="$emit('mua-san-pham')"
                >
                    {{ soLuongTon > 0 ? 'Mua' : 'Hết hàng' }}
                </button>
            </div>
        </div>
    `
};
