<div class="card">
    <div class="card-body">
        <div class="float-end d-none d-md-inline-block">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="btn btn-sm btn-light active " id="pills-home-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                        aria-selected="true">Monthly</button>
                </li>
                <!-- end li -->
                <li class="nav-item" role="presentation">
                    <button class="btn btn-sm btn-light ms-2 py-1" id="pills-profile-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                        aria-selected="false">Yearly</button>
                </li>
                <!-- end li -->
            </ul>
            <!-- end ul -->
        </div>
        <div>
            <h4 class="card-title mb-4">Overview</h4>
        </div>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                aria-labelledby="pills-home-tab">
                <div>
                    <div id="spline_area_month" class="column-charts" dir="ltr">
                    </div>
                </div>
            </div>
            <!-- end tab -->
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                <div>
                    <div id="spline_area_year" class="column-charts" dir="ltr">
                    </div>
                </div>
            </div>
            <!-- end tab -->
        </div>
    </div>
    <!-- end cardbody -->
</div>