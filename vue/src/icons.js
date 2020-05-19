import Vue from 'vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import {faComments,
        faPlusCircle,
        faPen, 
        faPenAlt,
        faPlusSquare
} from '@fortawesome/free-solid-svg-icons'


library.add(faComments, faPlusCircle, faPen, faPenAlt, faPlusSquare);

Vue.component('fa-icon', FontAwesomeIcon); 