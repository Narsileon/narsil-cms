import { ColumnDef } from "@tanstack/react-table";

import { Checkbox } from "@narsil-cms/blocks/fields";
import { useLabels } from "@narsil-cms/components/labels";
import type { Model } from "@narsil-cms/types";

function getSelectColumn(count: number): ColumnDef<Model> {
  const { trans } = useLabels();

  return {
    id: "_select",
    header: ({ table }) => {
      const checked = table.getIsAllPageRowsSelected();
      const indeterminate = table.getIsSomePageRowsSelected();

      const label = checked
        ? trans("", "Deselect all")
        : trans("", "Select all");

      return count > 0 ? (
        <Checkbox
          aria-label={label}
          checked={checked || (indeterminate && "indeterminate")}
          onCheckedChange={(value) => table.toggleAllPageRowsSelected(!!value)}
        />
      ) : null;
    },
    cell: ({ row }) => {
      const checked = row.getIsSelected();

      const label = checked
        ? trans("", "Deselect row")
        : trans("", "Select row");

      return (
        <Checkbox
          aria-label={label}
          checked={checked}
          onCheckedChange={(value) => row.toggleSelected(!!value)}
        />
      );
    },
    enableHiding: false,
    enableSorting: false,
  };
}

export default getSelectColumn;
