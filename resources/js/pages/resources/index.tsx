import { Button } from '@narsil-cms/components/ui/button';
import { Checkbox } from '@narsil-cms/components/ui/checkbox';
import { cn } from '@narsil-cms/lib/utils';
import { Link } from '@inertiajs/react';
import { PlusIcon } from 'lucide-react';
import { route } from 'ziggy-js';
import { Tooltip } from '@narsil-cms/components/ui/tooltip';
import { useLabels } from '@narsil-cms/components/ui/labels';
import DataTableBlock from '@narsil-cms/blocks/data-table-block';
import {
	DataTableFilter,
	DataTableInput,
	DataTablePagination,
	DataTableProvider,
	DataTableRowMenu,
	DataTableSettings,
} from '@narsil-cms/components/ui/data-table';
import { ResizableHandle, ResizablePanel, ResizablePanelGroup } from '@narsil-cms/components/ui/resizable';
import { Section, SectionContent, SectionFooter, SectionHeader, SectionTitle } from '@narsil-cms/components/ui/section';
import type { DataTableCollection, DataTableFilterCollection } from '@narsil-cms/types/collection';

type ResourceIndexProps = {
	dataTable: DataTableCollection;
	dataTableFilter: DataTableFilterCollection;
	title: string;
};

function ResourceIndex({ dataTable, dataTableFilter, title }: ResourceIndexProps) {
	const { getLabel } = useLabels();

	const finalColumns = [
		{
			id: '_select',
			cell: ({ row }: any) => (
				<Checkbox
					className='mx-1'
					checked={row.getIsSelected()}
					onCheckedChange={(value) => row.toggleSelected(!!value)}
					aria-label='Select row'
				/>
			),
			size: 32,
			enableSorting: false,
			enableHiding: false,
		},
		...dataTable.columns,
		{
			id: '_menu',
			cell: ({ row }: any) => (
				<DataTableRowMenu
					className='absolute top-1/2 right-1 -translate-y-1/2 transform'
					id={row.original.id}
					routes={dataTable.meta.routes}
				/>
			),
			position: 'sticky',
			size: 32,
			enableSorting: false,
			enableHiding: false,
		},
	];

	const finalColumnOrder = ['_select', ...dataTable.columnOrder];

	return (
		<DataTableProvider
			id={dataTable.meta.id}
			data={dataTable.data}
			columns={finalColumns}
			initialState={{
				columnOrder: finalColumnOrder,
				columnVisibility: dataTable.columnVisibility,
			}}
			render={({ dataTable: table }) => {
				return (
					<Section className='h-full gap-4 p-4'>
						<SectionHeader className='flex items-center justify-between gap-4'>
							<SectionTitle
								level='h2'
								variant='h4'
								className='min-w-1/5'
							>
								{title}
							</SectionTitle>
							<DataTableSettings className='ml-2' />
							<DataTableInput className='grow' />
							{dataTable.meta.routes.create ? (
								<Tooltip tooltip={getLabel('ui.create')}>
									<Button
										aria-label={getLabel('ui.create', 'Create')}
										size='icon'
										variant='default'
										asChild={true}
									>
										<Link href={route(dataTable.meta.routes.create)}>
											<PlusIcon />
										</Link>
									</Button>
								</Tooltip>
							) : null}
						</SectionHeader>
						<SectionContent className='grow'>
							<ResizablePanelGroup
								autoSaveId={dataTable.meta.id}
								direction='horizontal'
							>
								{dataTableFilter ? (
									<>
										<ResizablePanel
											className='pr-3'
											collapsible={true}
											defaultSize={20}
											minSize={10}
										>
											<DataTableFilter {...dataTableFilter} />
										</ResizablePanel>
										<ResizableHandle withHandle={true} />
									</>
								) : null}
								<ResizablePanel
									className={cn('flex flex-col gap-3', dataTableFilter && 'pl-3')}
									collapsible={true}
									defaultSize={80}
									minSize={10}
								>
									<DataTableBlock dataTable={table} />
								</ResizablePanel>
							</ResizablePanelGroup>
						</SectionContent>
						<SectionFooter className='grid grid-cols-2 gap-4 sm:grid-cols-4'>
							<span className='order-2 min-w-fit truncate text-sm sm:order-1'>
								{dataTable.meta.total > 0 ? getLabel('pagination.results') : getLabel('pagination.empty')}
							</span>
							<DataTablePagination
								className='order-1 col-span-2 sm:order-2'
								links={dataTable.links}
								metaLinks={dataTable.meta.links}
							/>
						</SectionFooter>
					</Section>
				);
			}}
		/>
	);
}

export default ResourceIndex;
