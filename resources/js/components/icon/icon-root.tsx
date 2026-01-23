import { cn } from "@narsil-cms/lib/utils";
import { getIcon, IconName } from "@narsil-cms/repositories/icons";
import { startCase } from "lodash-es";
import { type ComponentProps } from "react";

type IconRootProps = ComponentProps<"svg"> & {
  name: IconName;
};

function IconRoot({ className, name, ...props }: IconRootProps) {
  const Comp = getIcon(name);

  return (
    <Comp
      data-slot="icon-root"
      className={cn("size-5 text-primary", className)}
      aria-label={startCase(name)}
      {...props}
    />
  );
}

export default IconRoot;
