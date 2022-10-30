import { createStore } from 'vuex'
import options from './modules/options';
import brands from './modules/brands';
import products from './modules/products';
import kanban from './modules/kanban';
import cards from './modules/cards';
import auth from './modules/auth';

import { state } from './default';


export default createStore({
    modules: {
        options,
        brands,
        products,
        kanban,
        cards,
        auth
    },
    state
})
