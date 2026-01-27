<div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
    <!-- Registered Trees Card -->
    @include('Pages.Admin.reports.cards.trees')
    
    <!-- Cutting Permits Card -->
    @include('Pages.Admin.reports.cards.permits')
    
    <!-- Registered Chainsaws Card -->
    @include('Pages.Admin.reports.cards.chainsaws')
    
    <!-- Reported Incidents Card -->
    @include('Pages.Admin.reports.cards.incidents')
</div>