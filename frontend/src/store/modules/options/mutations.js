export default {
    setOptions: (states, objs) => states.listOptions = objs,
    removeOption: (state, id) => state.listOptions = state.listOptions.filter(data => data.id !== id),
    updateOptionMutation: (state, obj) => {
        // Remove o item
        state.listOptions = state.listOptions.filter(data => data.id !== obj.id);
        // Add o item
        state.listOptions.push(obj)
    },

    setOptionsValue: (states, objs) => states.listOptionsValue = objs,
    removeOptionValue: (state, id) => state.listOptionsValue = state.listOptionsValue.filter(data => data.id !== id),
}