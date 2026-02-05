import type { Model } from "@narsil-cms/types";
import { Checkbox } from "@narsil-ui/components/checkbox";
import { useLocalization } from "@narsil-ui/components/localization";
import { ColumnDef } from "@tanstack/react-table";

function getSelectColumn(): ColumnDef<Model> {
  const { trans } = useLocalization();

  return {
    id: "_select",
    header: ({ table }) => {
      const checked = table.getIsAllPageRowsSelected();
      const indeterminate = table.getIsSomePageRowsSelected();

      const label = checked ? trans("Deselect all") : trans("Select all");

      return table.options.data.length > 0 ? (
        <Checkbox
          aria-label={label}
          checked={checked}
          indeterminate={indeterminate}
          onCheckedChange={(value) => table.toggleAllPageRowsSelected(!!value)}
        />
      ) : null;
    },
    cell: ({ row }) => {
      const checked = row.getIsSelected();

      const label = checked ? trans("Deselect row") : trans("Select row");

      return (
        <div onClick={(event) => event.stopPropagation()}>
          <Checkbox
            aria-label={label}
            checked={checked}
            onCheckedChange={(value) => {
              row.toggleSelected(!!value);
            }}
          />
        </div>
      );
    },
    enableHiding: false,
    enableSorting: false,
    meta: {
      className: "min-w-9 w-9 max-w-9",
    },
  };
}

export default getSelectColumn;
