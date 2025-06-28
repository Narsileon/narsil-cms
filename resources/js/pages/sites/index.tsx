import DataTableBlock from "@/blocks/data-table-block";
import type { LaravelCollection } from "@/types/global";

function Index({ sites }: LaravelCollection) {
  return <DataTableBlock id="sites" {...sites} />;
}

export default Index;
