<?php
/**
 * Template Item
 */
?>

<div class="elementor-template-library-template-body">
	<div class="elementor-template-library-template-screenshot">
		<div class="elementor-template-library-template-title">
            <span class="">{{ title }}</span>
		</div>
		<img src="{{ thumbnail }}" alt="{{ title }}">
	</div>
</div>
<div class="elementor-template-library-template-controls">
    <button class="elementor-template-library-template-action bbelementor-template-insert elementor-button elementor-button-success">
        <i class="eicon-file-download"></i>
        <span class="elementor-button-title"><?php echo __( 'Insert', 'buddyboss-theme' ); ?></span>
    </button>
</div>