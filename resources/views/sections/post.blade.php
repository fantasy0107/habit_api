<div class="border  rounded border-gray-400 p-5">
    Title
    <input class="form-control
        block
        w-full
        px-3
        py-1.5
        text-base
        font-normal
        text-gray-700
        bg-white bg-clip-padding
        border border-solid border-gray-300
        rounded
        transition
        ease-in-out
        m-0
        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id='post_title' type='text' />
    Description
    <textarea id='post_description' class="
        form-control
        block
        w-full
        px-3
        py-1.5
        text-base
        font-normal
        text-gray-700
        bg-white bg-clip-padding
        border border-solid border-gray-300
        rounded
        transition
        ease-in-out
        m-0
        focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
      " id="exampleFormControlTextarea1" rows="3" placeholder="Your message"></textarea>
    <button class="bg-blue-500 text-white rounded m-1" id='create-post'>送出</button>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        const authorization = "Bearer <?= auth()->user()->api_token ?>";

        $('#create-post').on('click', function(event) {
            event.preventDefault();

            const title = $('#post_title').val();
            const description = $('#post_description').val();
            
            console.log(title, description, authorization);

            axios.post('/api/posts', {
                title,
                description
            }, {
                headers: {
                    Authorization: authorization
                }
            }).then((result) => {
                location.reload();
            }).catch((err) => {
                console.log('error', err.message);
            });;
        });

        
    });
</script>