import { Button } from "@/components/ui/button";
import { ChevronDown, ChevronsUpDown, ChevronUp } from "lucide-react";
import { Header } from "@tanstack/react-table";
import useTranslationsStore from "@/stores/translations-store";
import {
  Tooltip,
  TooltipContent,
  TooltipTrigger,
} from "@/components/ui/tooltip";

type DataTableHeadSortProps = React.ComponentProps<typeof Button> & {
  header: Header<any, any>;
};

function DataTableHeadSort({ header, ...props }: DataTableHeadSortProps) {
  const { trans } = useTranslationsStore();

  const isSorted = header.column.getIsSorted();

  return (
    <Tooltip tooltip={trans("accessibility.column_sort", "Sort column")}>
      <Button
        aria-label={trans("accessibility.column_sort", "Sort column")}
        className="size-6"
        size="icon"
        variant="ghost"
        onClick={header.column.getToggleSortingHandler()}
        {...props}
      >
        {isSorted === "asc" ? (
          <ChevronUp className="size-4" />
        ) : isSorted === "desc" ? (
          <ChevronDown className="size-4" />
        ) : (
          <ChevronsUpDown className="size-4" />
        )}
      </Button>
    </Tooltip>
  );
}

export default DataTableHeadSort;
