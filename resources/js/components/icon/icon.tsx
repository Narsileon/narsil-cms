import { startCase } from "lodash";

import { cn } from "@narsil-cms/lib/utils";
import { getIcon, IconName } from "@narsil-cms/plugins/icons";

type IconProps = React.ComponentProps<"svg"> & {
  name: IconName;
};

function Icon({ className, name, ...props }: IconProps) {
  const Comp = getIcon(name);

  return (
    <Comp
      data-slot="icon"
      className={cn("size-5", className)}
      aria-label={startCase(name)}
      {...props}
    />
  );
}

export default Icon;
