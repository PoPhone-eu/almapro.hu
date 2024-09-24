<div id="DeleteModal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <form action="" id="deleteForm" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <div class="modal-header bg-danger">

                    <h4 class="modal-title text-center text-white">TÖRLÉS MEGERŐSÍTÉSE</h4>
                </div>
                <div class="modal-body">
                    <h2 class="text-center">Biztos, hogy törlöd ?</h2>
                </div>
                <div class="modal-footer">
                    <center>
                        <button type="button" class="btn btn-outline-success w-24 inline-block mr-1 mb-2"
                            data-tw-dismiss="modal">Mégse</button>
                        <button type="submit" name="" class="btn btn-outline-danger w-24 inline-block mr-1 mb-2"
                            data-dismiss="modal" onclick="formSubmit()">Törlés</button>
                    </center>
                </div>
            </form>
        </div>
    </div>
</div>
