const { registerBlockType } = wp.blocks;

registerBlockType('wp-book/gutenberg-book-category', {
	// built-in attributes
	title: 'Book Category',
	description: 'Block to display books of selected category',
	icon: 'excerpt-view',
	category: 'widgets',


	// custom attributes
	attributes: {

    },


	// custom functions


	// builtin functions
	edit: ({className}) => {
		return (
            <div className={className}>hello world</div>
        )
	},
	save() {
        return (
            <div>hello world</div>
        )
    }
});