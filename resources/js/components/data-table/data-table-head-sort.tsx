import { Header } from "@tanstack/react-table";

import { Tooltip } from "@narsil-cms/blocks";
import { ButtonRoot } from "@narsil-cms/components/button";
import { Icon } from "@narsil-cms/components/icon";
import { useLabels } from "@narsil-cms/components/labels";

type DataTableHeadSortProps = React.ComponentProps<typeof ButtonRoot> & {
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
      <ButtonRoot
        aria-label={trans("accessibility.sort_column", "Sort column")}
        className="size-6"
        size="icon"
        variant="ghost"
        onClick={header.column.getToggleSortingHandler()}
        {...props}
      >
        <Icon className="size-4" name={getIconName()} />
      </ButtonRoot>
    </Tooltip>
  );
}

export default DataTableHeadSort;
