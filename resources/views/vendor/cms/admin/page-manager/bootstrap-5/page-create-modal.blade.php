<div class="modal fade" id="ModalPageCreate" tabindex="-1" aria-labelledby="ModalPageCreateLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalPageCreateLabel">
                    New Page
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form name="FORM_PAGE_CREATE" method="POST" action="<?php echo \Sinevia\Cms\Helpers\Links::adminPageCreate(); ?>">
                    <div class="form-group">
                        <label>Title</label>
                        <input class="form-control" name="Title" value="" placeholder="Enter page title" />
                    </div>
                    <?php echo csrf_field(); ?>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    @include("cms::shared/icons/bootstrap/bi-chevron-left")
                    Close
                </button>
                <button type="button" class="btn btn-success" onclick="FORM_PAGE_CREATE.submit();">
                    @include("cms::shared/icons/bootstrap/bi-check-circle")
                    Create page and edit
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function showPageCreateModal() {
        $('#ModalPageCreate').modal('show');
    }
</script>
