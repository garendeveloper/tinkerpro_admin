<style>
  

.printBtn {
  background: transparent;
  border-radius: 0;
  width: 120px;
}

button.btn.btn-secondary.printBtn.printCoupon {
  border: 1px solid var(--border-color);
  width: 120px;

}


.font-size{
  font-size: 12px !important;
}




</style>

<!-- Print Coupon Modal -->
<div class="modal" id="confirmModal" tabindex="0" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true" style="background-color: rgba(0, 0, 0, 0.5)">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 30vw">
        <div class="modal-content">

            <div style="position: relative; width: 100%; background: #262626; color: #ffff; height: 60px; border: 1px solid var(--border-color);" class="d-flex">
                <div style="margin-left: 5px; margin-top:10px; color:#ffff;">
                    <h4><span>
                        <svg width="40px" height="40px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M511.64164 924.327835c-228.816869 0-414.989937-186.16283-414.989937-414.989937S282.825796 94.347961 511.64164 94.347961c102.396724 0 200.763434 37.621642 276.975315 105.931176 9.47913 8.499272 10.266498 23.077351 1.755963 32.556481-8.488009 9.501656-23.054826 10.266498-32.556481 1.778489-67.723871-60.721519-155.148319-94.156494-246.174797-94.156494-203.396868 0-368.880285 165.482394-368.880285 368.880285S308.243749 878.218184 511.64164 878.218184c199.164126 0 361.089542-155.779033 368.60998-354.639065 0.49556-12.720751 11.032364-22.863359 23.910794-22.177356 12.720751 0.484298 22.649367 11.190043 22.15483 23.910794-8.465484 223.74966-190.609564 399.015278-414.675604 399.015278z" fill="#00A387"></path>
                                <path d="M960.926616 327.538868l-65.210232-65.209209-350.956149 350.956149-244.56832-244.566273-65.210233 65.209209 309.745789 309.743741 0.032764-0.031741 0.03174 0.031741z" fill="#00A387"></path>
                            </g>
                        </svg>
                    </span>Confirm <span></span></h4>
                </div>
            </div>

            <div class="modal-body" style="background: #262626; color: #ffff; border: 1px solid var(--border-color); text-align:center;">
                <h4>Are you sure you want to print this coupon?</h4>

                <svg width="211px" height="211px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M192 234.666667h640v64H192z" fill="#424242"></path>
                        <path d="M85.333333 533.333333h853.333334v-149.333333c0-46.933333-38.4-85.333333-85.333334-85.333333H170.666667c-46.933333 0-85.333333 38.4-85.333334 85.333333v149.333333z" fill="#616161"></path>
                        <path d="M170.666667 768h682.666666c46.933333 0 85.333333-38.4 85.333334-85.333333v-170.666667H85.333333v170.666667c0 46.933333 38.4 85.333333 85.333334 85.333333z" fill="#424242"></path>
                        <path d="M853.333333 384m-21.333333 0a21.333333 21.333333 0 1 0 42.666667 0 21.333333 21.333333 0 1 0-42.666667 0Z" fill="#00E676"></path>
                        <path d="M234.666667 85.333333h554.666666v213.333334H234.666667z" fill="#90CAF9"></path>
                        <path d="M800 661.333333h-576c-17.066667 0-32-14.933333-32-32s14.933333-32 32-32h576c17.066667 0 32 14.933333 32 32s-14.933333 32-32 32z" fill="#242424"></path>
                        <path d="M234.666667 661.333333h554.666666v234.666667H234.666667z" fill="#90CAF9"></path>
                        <path d="M234.666667 618.666667h554.666666v42.666666H234.666667z" fill="#42A5F5"></path>
                        <path d="M341.333333 704h362.666667v42.666667H341.333333zM341.333333 789.333333h277.333334v42.666667H341.333333z" fill="#1976D2"></path>
                    </g>
                </svg>
            </div>

            <div class="modal-footer" style="background: #262626; color: #ffff; border: 1px solid var(--border-color); display: flex; justify-content: space-between; padding: 10px;">
                <button class="btn btn-secondary printBtn printCancel" id="cancelPrintBtn" style="border: 1px solid #4B413E; box-shadow: none;">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-x-lg" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                        </svg>
                    </span>
                    CANCEL
                </button>

                <button class="btn btn-secondary printBtn printCoupon" id="confirmPrintBtn" tabindex="0" style="border: 1px solid #4B413E; box-shadow: none;">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" class="bi bi-check2" viewBox="0 0 16 16">
                            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0"/>
                        </svg>
                    </span>
                    YES
                </button>
            </div>
        </div>
    </div>
</div>
