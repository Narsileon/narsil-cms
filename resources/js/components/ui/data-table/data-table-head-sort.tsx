import { Button } from "@/components/ui/button";
import { ChevronDown, ChevronsUpDown, ChevronUp } from "lucide-react";
import { Header } from "@tanstack/react-table";
import useTranslationsStore from "@/stores/translations-store";
import {
  Tooltip,
  TooltipContent,
  TooltipTrigger,
} from "@/components/ui/tooltip";
import type { ButtonProps } from "@/components/ui/button";

export type DataTableHeadSortProps = ButtonProps & {
  header: Header<any, any>;
};

function DataTableHeadSort({ header, ...props }: DataTableHeadSortProps) {
  const { trans } = useTranslationsStore();

  const isSorted = header.column.getIsSorted();

  return (
    <Tooltip>
      <TooltipTrigger asChild={true}>
        <Button
          aria-label={trans("accessibility.column_sort", "Sort column")}
          size="icon"
          variant="ghost"
          onClick={header.column.getToggleSortingHandler()}
          {...props}
        >
          {isSorted === "asc" ? (
            <ChevronUp />
          ) : isSorted === "desc" ? (
            <ChevronDown />
          ) : (
            <ChevronsUpDown />
          )}
        </Button>
      </TooltipTrigger>
      <TooltipContent>
        {trans("accessibility.column_sort", "Sort column")}
      </TooltipContent>
    </Tooltip>
  );
}

export default DataTableHeadSort;
