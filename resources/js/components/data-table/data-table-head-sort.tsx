import { Header } from "@tanstack/react-table";
import { type ComponentProps } from "react";

import { Button } from "@narsil-cms/blocks";
import { useLocalization } from "@narsil-cms/components/localization";
import type { Model } from "@narsil-cms/types";

type DataTableHeadSortProps = ComponentProps<typeof Button> & {
  header: Header<Model, unknown>;
};

function DataTableHeadSort({ header, ...props }: DataTableHeadSortProps) {
  const { trans } = useLocalization();

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

  const tooltip = trans("accessibility.sort_column");

  return (
    <Button
      className="size-6"
      iconProps={{
        className: "size-4",
        name: getIconName(),
      }}
      size="icon"
      tooltip={tooltip}
      variant="ghost"
      onClick={header.column.getToggleSortingHandler()}
      {...props}
    />
  );
}

export default DataTableHeadSort;
