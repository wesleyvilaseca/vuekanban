const mutations = {
    setProducts: (state, products) => state.listProducts = products,
    removeProduct: (state, id) => state.listProducts = state.listProducts.filter(data => data.id !== id),
    updateProductMutation: (state, obj) => {
        // Remove o item
        state.listProducts = state.listProducts.filter(data => data.id !== obj.id);
        // Add o item
        state.listProducts.push(obj)
    }
};

export default mutations;