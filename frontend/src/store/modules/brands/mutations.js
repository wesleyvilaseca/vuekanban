const mutations = {
    setBrands: (states, brands) => states.listBrands = brands,
    removeBrand: (state, id) => state.listBrands = state.listBrands.filter(data => data.id !== id),
    updateBrandMutation: (state, obj) => {
        // Remove o item
        state.listBrands = state.listBrands.filter(data => data.id !== obj.id);
        // Add o item
        state.listBrands.push(obj)
    }
}

export default mutations;