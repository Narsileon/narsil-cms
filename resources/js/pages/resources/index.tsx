import { route } from "ziggy-js";
import DataTableBlock from "@/blocks/data-table-block";
import useTranslationsStore from "@/stores/translations-store";
import type { LaravelCollection, LaravelForm } from "@/types/global";

type IndexProps = {
  form: LaravelForm;
  collection: LaravelCollection;
};

function ResourceIndex({ collection }: IndexProps) {
  const { trans } = useTranslationsStore();

  return (
    <DataTableBlock
      id="sites"
      className="col-span-3 h-full p-4"
      createHref={route("sites.create")}
      title={trans("ui.sites", "Sites")}
      {...collection}
    />
  );
}

export default ResourceIndex;
