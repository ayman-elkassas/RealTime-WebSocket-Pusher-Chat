<!--TODO:to make this separated should install vue-loader with compatible version with webpack-->

<!--Todo:html-->
<template src="./chats.html" lang="html"></template>
<!--Todo:css-->
<style src="./chats.css" lang="css"></style>
<!--Todo:js (as a .vue)-->
<script>

    axios=window.axios;

    export default {
        props:{
            'user':{
                type:Object
            }
        },
        data() {
            return{
                allMessages:[],
                newMessage:'',
            }
        },
        created() {
            //to get all message to prepare it in chat on created vm object
            this.getMessages();

            let vm=this;

            //todo:to get message is broadcast now on channel chats and update chat view
            //todo:this will happen after save message when broadcast message is share on channel and fire event
            //todo:here you listen on firing specific event attached on channel 'chats'
            //todo:may be many events attached on channel
            window.Echo.join('chats')
                .listen('SendMessageEvent', (event) => {
                //debugger;
                alert(event.message);
                vm.allMessages.push(event.message);
            });

        },
        methods:{
            getMessages(){
                //make object as outer scope for axios (اكسى يوس) used scoping
                let vm=this;
                //get response (who send, and message)
                axios.get('messages').then(response=>{
                    vm.allMessages=response.data;
                });
            },
            saveMessage(){
                //todo:to handle design chat
                // debugger;
                let vm=this;
                this.allMessages.push({
                    user:vm.user,
                    message:vm.newMessage
                });

                //todo:to send newMessage and save
                axios.post('messages',{message:vm.newMessage}).then(response=>{
                    console.log(response.data);
                });

                this.newMessage = '';
            },
        }
    }
</script>
