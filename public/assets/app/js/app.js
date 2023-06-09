document.addEventListener('DOMContentLoaded', () => {
    new CommentBlog();
})

class CommentBlog {
    constructor() {
        this.handleCommentForm()
    }
    handleCommentForm() {
        const commentForm = document.querySelector('form.comment-form');

        if (null === commentForm){
            return;
        }

        commentForm.addEventListener('submit', async(e) =>{
            e.preventDefault();
            const response = await fetch('/blog/ajax/comment', {
                method: 'POST',
                body: new FormData(e.target)
            })
            if (!response.ok){
                return;
            }

            const json = await response.json();

            if(json.code === 'COMMENT_USER_SUCCESSFULLY'){
                const commentList = document.querySelector('.comment-list');
                const commentCount = document.querySelector('.comment-count');
                const commentContent = document.querySelector('#comment_content');console.log(commentCount);

                commentList.insertAdjacentHTML('beforeend', json.message);
                commentList.lastElementChild.scrollIntoView();
                commentCount.innerText = json.number_comments;
                commentContent.value = '';
            }
        } )
    }
}