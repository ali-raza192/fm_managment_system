<aside class="left-sidebar">
  <!-- Sidebar scroll-->
  <div class="scroll-sidebar">
    <!-- User profile -->
    <div
      class="user-profile position-relative"
      style="
        background: url({{ asset('admin/assets/images/background/user-info1.jpg') }})
          no-repeat;
      "
    >
    @php
    $id = Auth::User()->id;
    $adminData = App\Models\User::find($id);
    @endphp
      <!-- User profile image -->
      <div class="profile-img">
        <img
          src="{{ (!empty($adminData->photo)) ? url('upload/admin_images/'.$adminData->photo) : url('upload/no_image.jpg') }}"
          alt="user"
          class="w-100"
          style="border-radius: 50%"
        />
      </div>
      <!-- User profile text-->
      <div class="profile-text pt-1 dropdown">
        <a
          href="#"
          class="
            dropdown-toggle
            u-dropdown
            w-100
            text-white
            d-block
            position-relative
          "
          id="dropdownMenuLink"
          data-bs-toggle="dropdown"
          aria-expanded="false"
          >Hi {{ Illuminate\Support\Str::limit($adminData->name, 14, ' ...') }}</a
        >
        <div
          class="dropdown-menu animated flipInY"
          aria-labelledby="dropdownMenuLink"
        >
          <a class="dropdown-item" href="{{ route('admin.profile.edit') }}"
            ><i
              data-feather="user"
              class="feather-sm text-info me-1 ms-1"
            ></i>
            My Profile</a
          >
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{ route('logout') }}"
            ><i
              data-feather="log-out"
              class="feather-sm text-danger me-1 ms-1"
            ></i>
            Logout</a
          >
          <div class="dropdown-divider"></div>
          <div class="ps-4 p-2">
            <a href="{{ route('admin.profile.edit') }}" class="btn d-block w-100 btn-info rounded-pill"
              >View Profile</a
            >
          </div>
        </div>
      </div>
    </div>
    <!-- End User profile text-->
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav">
      <ul id="sidebarnav">
        <li class="nav-small-cap">
          <i class="mdi mdi-dots-horizontal"></i>
          <span class="hide-menu">Personal</span>
        </li>
        @if (Auth::user()->can('create.account'))
        <li class="sidebar-item">
          <a
            class="sidebar-link has-arrow waves-effect waves-dark"
            href="javascript:void(0)"
            aria-expanded="false"
          >
            <i class="mdi mdi-checkbox-multiple-marked-circle-outline"></i>
            <span class="hide-menu">Deputy Director Finance </span>
          </a>
          <ul aria-expanded="false" class="collapse first-level">
            @if (Auth::user()->can('final.approval.of.expense.voucher'))
            <li class="sidebar-item">
              <a href="{{ route('view.expense.voucher.of.deputy.director') }}" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="top" title="Final Approval or Objection on Expense Vouchers">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu">Final Approval or Objection on Expense Vouchers</span>
              </a>
            </li>
            @endif
            @if (Auth::user()->can('create.account'))
            <li class="sidebar-item">
              <a href="{{ route('manage.accounts') }}" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="top" title="Create Accounts">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu"> Create Accounts  </span>
              </a>
            </li>
            @endif
            @if (Auth::user()->can('approve.chart.of.account'))
            <li class="sidebar-item">
              <a href="{{ route('approve.chart.of.account') }}" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="top" title="Approve Chart of Accounts for DDOs">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu">Approve Chart of Accounts for DDOs</span>
              </a>
            </li>
            @endif
            @if (Auth::user()->can('approve.ddo'))
            <li class="sidebar-item">
              <a href="{{ route('approve.ddo_assignment_to_accountant') }}" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="top" title="Approve DDO Assignments to Accountants">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu">Approve DDO Assignments to Accountants</span>
              </a>
            </li>
            @endif
            @if (Auth::user()->can('approve.budget'))
            <li class="sidebar-item">
              <a href="{{ route('approve.budget') }}" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="top" title="Approve Budget Allocations to the DDOs">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu">Approve Budget Allocations to the DDOs</span>
              </a>
            </li>
            @endif
            @if (Auth::user()->can('approve.advance'))
            <li class="sidebar-item">
              <a href="{{ route('approve.advance') }}" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="top" title="Approve Advances to DDOs">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu">Approve Advances to DDOs</span>
              </a>
            </li>
            @endif
          </ul>
        </li>
        @endif


        @if (Auth::user()->can('assign.ddo.to.accountant'))
        <li class="sidebar-item">
          <a
            class="sidebar-link has-arrow waves-effect waves-dark"
            href="javascript:void(0)"
            aria-expanded="false"
          >
            <i class="mdi mdi-checkbox-multiple-marked-circle-outline"></i>
            <span class="hide-menu">Account Officer </span>
          </a>
          <ul aria-expanded="false" class="collapse first-level">
            @if (Auth::user()->can('approve.or.raise.expense.voucher'))
            <li class="sidebar-item">
              <a href="{{ route('view.expense.voucher.of.account.officer') }}" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="top" title="Approve or Raise Objections on Expense Vouchers">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu">Approve or Raise Objections on Expense Vouchers</span>
              </a>
            </li>
            @endif
            @if (Auth::user()->can('assign.ddo.to.accountant'))
            <li class="sidebar-item">
              <a href="{{ route('assign.ddos.to.accountants') }}" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign DDOs to Accountants">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu">Assign DDOs to Accountants</span>
              </a>
            </li>
            @endif
            @if (Auth::user()->can('assign.budget.to.ddo'))
            <li class="sidebar-item">
              <a href="{{ route('send.request.to approve.budget') }}" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Budget to the DDOs">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu">Add Budget to the DDOs</span>
              </a>
            </li>
            @endif
            @if (Auth::user()->can('add.advance.to.ddo'))
            <li class="sidebar-item">
              <a href="{{ route('send.request.to approve.advance') }}" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Advance to DDOs">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu">Add Advance to DDOs</span>
              </a>
            </li>
            @endif
          </ul>
        </li>
        @endif


        @if (Auth::user()->can('add.chart.of.account'))
        <li class="sidebar-item">
          <a
            class="sidebar-link has-arrow waves-effect waves-dark"
            href="javascript:void(0)"
            aria-expanded="false"
          >
            <i class="mdi mdi-checkbox-multiple-marked-circle-outline"></i>
            <span class="hide-menu">Assistant Account Officer</span>
          </a>
          <ul aria-expanded="false" class="collapse first-level">
            @if (Auth::user()->can('approve.expense.voucher'))
            <li class="sidebar-item">
              <a href="{{ route('view.expense.voucher.of.assistant.accountant') }}" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="top" title="Approve or Raise Objections on Expense Vouchers submitted by DDOs">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu">Approve or Raise Objections on Expense Vouchers submitted by DDOs</span>
              </a>
            </li>
            @endif
            @if (Auth::user()->can('add.chart.of.account'))
            <li class="sidebar-item">
              <a href="{{ route('create.chart.of.account') }}" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Chart of Accounts for DDOs">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu">Add Chart of Accounts for DDOs</span>
              </a>
            </li>
            @endif
          </ul>
        </li>
        @endif


        @if (Auth::user()->can('approve.raise.expense.voucher'))
        <li class="sidebar-item">
          <a
            class="sidebar-link has-arrow waves-effect waves-dark"
            href="javascript:void(0)"
            aria-expanded="false"
          >
            <i class="mdi mdi-checkbox-multiple-marked-circle-outline"></i>
            <span class="hide-menu">Accountant</span>
          </a>
          <ul aria-expanded="false" class="collapse first-level">
            <li class="sidebar-item">
              <a href="{{ route('view.expense.voucher.of.accountant') }}" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="top" title="Approve or Raise Objections on Expense Vouchers submitted by DDOs">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu">Approve or Raise Objections on Expense Vouchers submitted by DDOs</span>
              </a>
            </li>
          </ul>
        </li>
        @endif

        @if (Auth::user()->can('add.expense.voucher'))
        <li class="sidebar-item">
          <a
            class="sidebar-link has-arrow waves-effect waves-dark"
            href="javascript:void(0)"
            aria-expanded="false"
          >
            <i class="mdi mdi-checkbox-multiple-marked-circle-outline"></i>
            <span class="hide-menu">DDOs</span>
          </a>
          <ul aria-expanded="false" class="collapse first-level">
            <li class="sidebar-item">
              <a href="{{ route('expence.vouchers.all') }}" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Expenses Vouchers in Different Chart of Accounts">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu">Add Expenses Vouchers in Different Chart of Accounts</span>
              </a>
            </li>
          </ul>
        </li>
        @endif

        {{-- <li class="sidebar-item">
          <a
            class="sidebar-link has-arrow waves-effect waves-dark"
            href="javascript:void(0)"
            aria-expanded="false"
          >
            <i class="mdi mdi-checkbox-multiple-marked-circle-outline"></i>
            <span class="hide-menu">Permissions</span>
          </a>
          <ul aria-expanded="false" class="collapse first-level">
            <li class="sidebar-item">
              <a href="{{ route('permissions.all') }}" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="top" title="All Permissions">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu">All Permissions</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a href="{{ route('roles.all') }}" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="top" title="All Roles">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu">Roles</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a href="{{ route('add.roles.and.permissions') }}" class="sidebar-link" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Roles And Permissions">
                <i class="mdi mdi-adjust"></i>
                <span class="hide-menu">Add Roles And Permissions</span>
              </a>
            </li>
          </ul>
        </li> --}}

        
      </ul>
    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
  <!-- Bottom points-->
  <div class="sidebar-footer">
    <!-- item-->
    <a
      href="{{ route('admin.setting') }}"
      class="link"
      data-bs-toggle="tooltip"
      data-bs-placement="top"
      title="Settings"
      ><i class="ti-settings"></i
    ></a>
    <!-- item-->
    <a
      href="#"
      class="link"
      ></a>
    <!-- item-->
    <a
      href="{{ route('logout') }}"
      class="link"
      data-bs-toggle="tooltip"
      data-bs-placement="top"
      title="Logout"
      ><i class="mdi mdi-power"></i
    ></a>
  </div>
  <!-- End Bottom points-->
</aside>