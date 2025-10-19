import Array from "./array";
import ArrayItem from "./array-item";

type ArrayElement = Record<string, string> & {
  uuid: string;
};

export { Array, ArrayItem };

export type { ArrayElement };
