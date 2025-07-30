<x-layout.admin-panel title="Dashboard">
    <p>Welcome, {{ auth()->user()->name }}!</p>
    <p>Test table component</p>
    <div>
        <x-ui.card class="mt-2">
            <x-ui.card.content>
                <x-ui.table>
                    <x-ui.table.caption>A list of your recent invoices.</x-ui.table.caption>
                    <x-ui.table.header>
                        <x-ui.table.row>
                            <x-ui.table.head class="w-[200px]">Invoice</x-ui.table.head>
                            <x-ui.table.head>Status</x-ui.table.head>
                            <x-ui.table.head>Method</x-ui.table.head>
                            <x-ui.table.head class="text-right">Amount</x-ui.table.head>
                        </x-ui.table.row>
                    </x-ui.table.header>
                    <x-ui.table.body>
                        @for($i = 0; $i < 10; ++$i)
                            <x-ui.table.row>
                                <x-ui.table.cell class="font-medium p-6">INV001</x-ui.table.cell>
                                <x-ui.table.cell>Paid</x-ui.table.cell>
                                <x-ui.table.cell>Credit Card</x-ui.table.cell>
                                <x-ui.table.cell class="text-right">$250.00</x-ui.table.cell>
                            </x-ui.table.row>
                        @endfor
                    </x-ui.table.body>
                </x-ui.table>
            </x-ui.card.content>
        </x-ui.card>
    </div>
</x-layout.admin-panel>
