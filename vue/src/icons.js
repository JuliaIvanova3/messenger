import Vue from 'vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import {faComments,
        faPlusCircle,
        faPen, 
        faPenAlt,
        faPlusSquare,
        faPaperPlane,
        faPaperclip,
        faCheck,
        faCheckSquare,
        faTrash,
        faWindowClose,
        faUpload
} from '@fortawesome/free-solid-svg-icons'


library.add(faComments, faPlusCircle, faPen, faPenAlt, faPlusSquare, faPaperclip, faPaperPlane, faCheck,faCheckSquare, faTrash, faWindowClose, faUpload);

Vue.component('fa-icon', FontAwesomeIcon); 