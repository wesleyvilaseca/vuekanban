import { createStore } from 'vuex'
import kanban from './modules/kanban';
import cards from './modules/cards';
import auth from './modules/auth';
import projects from './modules/projects';

import { state } from './default';


export default createStore({
    modules: {
        kanban,
        cards,
        auth,
        projects
    },
    state
})
