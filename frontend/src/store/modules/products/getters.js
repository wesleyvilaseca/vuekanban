const getters = {
    getProducts: (state) => {
        let produtos = state.listProducts;
        let itens = [];

        produtos.forEach((x) => {
            itens.push({
                id: x.id,
                title: x.title,
                description: x.description,
                brand: x.brand.name
            });
        });

        return itens;
    },
    getNewsProducts: (state, getters) => getters.getProducts.reverse().slice(0, 5),
    totalProducts: (state) => state.listProducts.length,
};

export default getters;