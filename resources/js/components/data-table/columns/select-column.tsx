import { Checkbox } from "@narsil-cms/blocks/fields";
import { useLocalization } from "@narsil-cms/components/localization";
import type { Model } from "@narsil-cms/types";
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
          checked={checked || (indeterminate && "indeterminate")}
          onCheckedChange={(value) => table.toggleAllPageRowsSelected(!!value)}
        />
      ) : null;
    },
    cell: ({ row }) => {
      const checked = row.getIsSelected();

      const label = checked ? trans("Deselect row") : trans("Select row");

      return (
        <Checkbox
          aria-label={label}
          checked={checked}
          onClick={(event) => event.stopPropagation()}
          onCheckedChange={(value) => row.toggleSelected(!!value)}
        />
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
