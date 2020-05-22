<template>
    <div class="container">
        <div class="card card-default">
            <div class="card-header">Home</div>
            <div class="card-body">
                <button @click="add">Addd</button>
                <div class="scroll" ref="scroll">
                    <ul>
                        <li v-for="(item, index) in array"
                            :key=index
                        >
                            {{item.name}}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            array: [
                {name: "new" , item: 2},
                 {name: "new" , item: 2},
                  {name: "new" , item: 2},
                   {name: "new" , item: 2}
            ]
        }
    },
    methods: {
        add() {
            let str = Date.now()
            this.array.push({name: str , item: 2});
        },
         scrollToEnd () {
            var content = this.$refs.scroll;
            content.scrollTop = content.scrollHeight;
        }
    },
    updated () {
        // This will be called when the component updates
        // try toggling a todo
        this.scrollToEnd(); 
    },
    
    mounted () {
        // This will be called on load
        this.scrollToEnd();	
    }
}
</script>
<style scoped>
.scroll {
    height: 100px;
    overflow: scroll;
}
</style>