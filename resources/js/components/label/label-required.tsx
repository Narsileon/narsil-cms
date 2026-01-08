import { Tooltip } from "@/blocks/tooltip";
import { useLocalization } from "@narsil-cms/components/localization";
import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type LabelRequiredProps = ComponentProps<"span"> & {};

function LabelRequired({ className }: LabelRequiredProps) {
  const { trans } = useLocalization();

  return (
    <Tooltip tooltip={trans("accessibility.required")}>
      <span className={cn(className, "text-red-500")}>*</span>
    </Tooltip>
  );
}

export default LabelRequired;
