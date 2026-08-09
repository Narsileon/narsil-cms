import { Status } from "@narsil-cms/blocks/status";
import type { Model } from "@narsil-cms/types";
import {
  createDataTableColumnHelper,
  type DataTableColumnDef,
} from "@narsil-ui/components/data-table";
import { cn } from "@narsil-ui/lib/utils";

const columnHelper = createDataTableColumnHelper<Model>();

function getStatusColumn(): DataTableColumnDef<Model> {
  return columnHelper.display({
    id: "_status",
    cell: ({ row }) => {
      return (
        <Status
          draft={!!row.original.draft}
          published={!!row.original.published_revision}
          saved={row.original.published_revision?.uuid !== row.original.uuid}
        />
      );
    },
    enableHiding: false,
    enableSorting: false,
    meta: {
      className: cn(
        "w-8 max-w-8 min-w-8 pl-2",
        "hover:w-12 hover:max-w-12 hover:min-w-12",
        "transition-[min-width,width,max-width] delay-100 duration-300",
      ),
    },
  });
}

export default getStatusColumn;
