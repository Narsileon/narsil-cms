import { useLocalization } from "@narsil-cms/components/localization";
import { StatusItem, StatusRoot } from "@narsil-cms/components/status";
import { cn } from "@narsil-cms/lib/utils";
import type { Model } from "@narsil-cms/types";
import { ColumnDef } from "@tanstack/react-table";

function getStatusColumn(): ColumnDef<Model> {
  return {
    id: "_status",
    cell: ({ row }) => {
      const { trans } = useLocalization();

      return (
        <StatusRoot>
          {row.original.published_revision ? (
            <StatusItem className="bg-green-500" tooltip={trans("revisions.published")} />
          ) : null}
          {row.original.published_revision?.uuid !== row.original.uuid ? (
            <StatusItem className="bg-amber-500" tooltip={trans("revisions.saved")} />
          ) : null}
          {row.original.draft ? (
            <StatusItem className="bg-red-500" tooltip={trans("revisions.draft")} />
          ) : null}
        </StatusRoot>
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
  };
}

export default getStatusColumn;
