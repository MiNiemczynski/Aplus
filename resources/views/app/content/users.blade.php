<x-cards-row :cards="$actioncards ?? []" title="Roles" />

<div class="border border-end-0 overflow-auto m-2 p-2">
    <x-cards-container :cards="$admins ?? []" title="Admins" />
    <x-cards-container :cards="$students ?? []" title="Students" />
    <x-cards-container :cards="$teachers ?? []" title="Teachers" />
</div>