const { createApp } = Vue;

const app = createApp({
    data() {
        return {
            products: [
                {
                    id: 1,
                    ten: "Laptop Dell Inspiron",
                    gia: 15000000,
                    anh: "https://placehold.co/300x200?text=Laptop",
                    moTa: "Laptop Dell phù hợp cho học tập, làm việc và giải trí.",
                    soLuongTon: 5
                },
                {
                    id: 2,
                    ten: "Điện thoại Samsung",
                    gia: 10000000,
                    anh: "https://placehold.co/300x200?text=Phone",
                    moTa: "Điện thoại Samsung có thiết kế hiện đại và hiệu năng tốt.",
                    soLuongTon: 8
                },
                {
                    id: 3,
                    ten: "Tai nghe Bluetooth",
                    gia: 750000,
                    anh: "https://placehold.co/300x200?text=Headphones",
                    moTa: "Tai nghe không dây tiện lợi khi học tập và nghe nhạc.",
                    soLuongTon: 12
                },
                {
                    id: 4,
                    ten: "Đồng hồ thông minh",
                    gia: 2000000,
                    anh: "https://placehold.co/300x200?text=Watch",
                    moTa: "Đồng hồ thông minh hỗ trợ theo dõi hoạt động hằng ngày.",
                    soLuongTon: 0
                }
            ]
        };
    },

    methods: {
        muaSanPham(id) {
            const product = this.products.find(
                item => item.id === id
            );

            if (!product || product.soLuongTon <= 0) {
                return;
            }

            product.soLuongTon--;

            alert(
                "Mua hàng thành công!\n" +
                "Sản phẩm: " + product.ten +
                "\nSố lượng tồn còn lại: " + product.soLuongTon
            );
        }
    }
});

app.component("the-san-pham", TheSanPham);

app.mount("#app");