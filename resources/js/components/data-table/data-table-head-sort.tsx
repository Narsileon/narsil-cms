import { Header } from "@tanstack/react-table";
import { type ComponentProps } from "react";

import { Button, Tooltip } from "@narsil-cms/blocks";
import { useLabels } from "@narsil-cms/components/labels";

type DataTableHeadSortProps = ComponentProps<typeof Button> & {
  header: Header<unknown, unknown>;
};

function DataTableHeadSort({ header, ...props }: DataTableHeadSortProps) {
  const { trans } = useLabels();

  function getIconName() {
    switch (header.column.getIsSorted()) {
      case "asc":
        return "chevron-up";
      case "desc":
        return "chevron-down";
      default:
        return "chevrons-up-down";
    }
  }

  return (
    <Tooltip tooltip={trans("accessibility.sort_column")}>
      <Button
        aria-label={trans("accessibility.sort_column", "Sort column")}
        className="size-6"
        iconProps={{
          className: "size-4",
          name: getIconName(),
        }}
        size="icon"
        variant="ghost"
        onClick={header.column.getToggleSortingHandler()}
        {...props}
      />
    </Tooltip>
  );
}

export default DataTableHeadSort;
