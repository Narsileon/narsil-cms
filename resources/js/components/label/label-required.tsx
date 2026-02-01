import { cn } from "@narsil-cms/lib/utils";
import { type ComponentProps } from "react";

type LabelRequiredProps = ComponentProps<"span"> & {
  label?: string;
};

function LabelRequired({
  className,
  label = "This field is required",
  ...props
}: LabelRequiredProps) {
  return (
    <span
      data-slot="label-required"
      className={cn("text-destructive", className)}
      aria-label={label}
      {...props}
    >
      *
    </span>
  );
}

export default LabelRequired;
