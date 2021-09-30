const { registerBlockType } = wp.blocks;

registerBlockType('wp-book/gutenberg-book-category', {
	// built-in attributes
	title: 'Book Category',
	description: 'Block to display books of selected category',
	icon: 'excerpt-view',
	category: 'widgets',


	// custom attributes
	attributes: {
        selected: {
            type: 'text',
        },
    },


	// custom functions


	// builtin functions
	edit: (props) => {

        function handleChange(e) {
            console.log(e.target.value + "value");
            props.setAttributes(
                {
                    selected: e.target.value,
                }
            );
            console.log(props.attributes.selected + "props");
        }

		return (
            <div className='wp-book-cat-block'>
                <p>Select a category form below to display books:</p>
                <select name='categories' onChange={handleChange}>
                    {
                        wp_book_vars.category.map(
                            (category) => ( <option value={category}>{category}</option> )
                        )
                    }
                </select>
            </div>
        )
	},
	save() {
        return null;
    }
});
