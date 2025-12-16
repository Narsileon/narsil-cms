import type { Block } from "@narsil-cms/types";
import Builder from "./builder";
import BuilderAdd from "./builder-add";
import BuilderItem from "./builder-item";

type BuilderElement = {
  block: Block;
  uuid: string;
  values: Record<string, unknown>;
};

export { Builder, BuilderAdd, BuilderItem };

export type { BuilderElement };
